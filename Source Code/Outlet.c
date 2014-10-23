#include <avr/io.h>
#include <avr/interrupt.h>
#include <util/delay.h>
#include <math.h>
#include <stdlib.h>
#define ADC_VREF_TYPE 0x40
/*
Copyright (c) 2007 Stefan Engelke <mbox@stefanengelke.de>
Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
*/

/* Memory Map */
#define CONFIG 0x00
#define EN_AA 0x01
#define EN_RXADDR 0x02
#define SETUP_AW 0x03
#define SETUP_RETR 0x04
#define RF_CH 0x05
#define RF_SETUP 0x06
#define STATUS 0x07
#define OBSERVE_TX 0x08
#define CD 0x09
#define RX_ADDR_P0 0x0A
#define RX_ADDR_P1 0x0B
#define RX_ADDR_P2 0x0C
#define RX_ADDR_P3 0x0D
#define RX_ADDR_P4 0x0E
#define RX_ADDR_P5 0x0F
#define TX_ADDR 0x10
#define RX_PW_P0 0x11
#define RX_PW_P1 0x12
#define RX_PW_P2 0x13
#define RX_PW_P3 0x14
#define RX_PW_P4 0x15
#define RX_PW_P5 0x16
#define FIFO_STATUS 0x17
#define DYNPD 0x1C
#define FEATURE 0x1D

/* Bit Mnemonics */
#define MASK_RX_DR 6
#define MASK_TX_DS 5
#define MASK_MAX_RT 4
#define EN_CRC 3
#define CRCO 2
#define PWR_UP 1
#define PRIM_RX 0
#define ENAA_P5 5
#define ENAA_P4 4
#define ENAA_P3 3
#define ENAA_P2 2
#define ENAA_P1 1
#define ENAA_P0 0
#define ERX_P5 5
#define ERX_P4 4
#define ERX_P3 3
#define ERX_P2 2
#define ERX_P1 1
#define ERX_P0 0
#define AW 0
#define ARD 4
#define ARC 0
#define PLL_LOCK 4
#define RF_DR 3
#define RF_PWR 6
#define RX_DR 6
#define TX_DS 5
#define MAX_RT 4
#define RX_P_NO 1
#define TX_FULL 0
#define PLOS_CNT 4
#define ARC_CNT 0
#define TX_REUSE 6
#define FIFO_FULL 5
#define TX_EMPTY 4
#define RX_FULL 1
#define RX_EMPTY 0
#define DPL_P5 5
#define DPL_P4 4
#define DPL_P3 3
#define DPL_P2 2
#define DPL_P1 1
#define DPL_P0 0
#define EN_DPL 2
#define EN_ACK_PAY 1
#define EN_DYN_ACK 0

/* Instruction Mnemonics */
#define R_REGISTER 0x00
#define W_REGISTER 0x20
#define REGISTER_MASK 0x1F
#define ACTIVATE 0x50
#define R_RX_PL_WID 0x60
#define R_RX_PAYLOAD 0x61
#define W_TX_PAYLOAD 0xA0
#define W_ACK_PAYLOAD 0xA8
#define FLUSH_TX 0xE1
#define FLUSH_RX 0xE2
#define REUSE_TX_PL 0xE3
#define NOP 0xFF

/* Non-P omissions */
#define LNA_HCURR 0

/* P model memory Map */
#define RPD 0x09

/* P model bit Mnemonics */
#define RF_DR_LOW 5
#define RF_DR_HIGH 3
#define RF_PWR_LOW 1
#define RF_PWR_HIGH 2

/* W/R Mnemonics */
#define W 1
#define R 0

/* Others */
#define BIT(x) (1 << (x))
#define SETBITS(x,y) ((x) |= (y))
#define CLEARBITS(x,y) ((x) &= (~(y)))
#define SETBIT(x,y) SETBITS((x), (BIT((y))))
#define CLEARBIT(x,y) CLEARBITS((x), (BIT((y))))

#define sbi(x,y) (x) |= _BV((y))
#define cbi(x,y) (x) &= ~_BV((y))
#define wbi(x,y,z) if (z) sbi((x),(y)); else cbi((x),(y))
#define rbi(x,y) ((x) & _BV((y)))

#define I1_ADC 3
#define I1_ADC_P PORTC
#define I2_ADC 5
#define I2_ADC_P PORTC
#define V_ADC 4
#define V_ADC_P PORTC
#define RXLED 6
#define RXLED_P PORTD
#define TXLED 7
#define TXLED_P PORTD
#define POWERLED 4
#define POWERLED_P PORTD
#define ENERGYLED 2
#define ENERGYLED_P PORTB
#define RELAY 2
#define RELAY_P PORTD
#define CSN 0
#define CSN_P PORTB
#define CE 1
#define CE_P PORTB
#define RFIRQ 3
#define RFIRQ_P PORTD

// Receive Bytes :  
// Byte 0 - Commands
//  Bit 7 - Load Data
//  Bit 0 - Switch

// Transmit Bytes :
// Byte 12..9 - Voltage Reading
// Byte 8..5 - Current Reading
// Byte 4..1 - Power Reading
// Byte 0 :
//  Bit 0 - Switch State

// Timer :
// Energy Pulse

// ADC : Free Running, Interrupt Enabled


// Global Variables

unsigned char readFlag, switchState, loadData, ADCCount;
unsigned int sample, sample_Temp;
unsigned int VTemp, I1Temp, I2Temp;
float VRaw, I1Raw, I2Raw, I1Sqr, I2Sqr;
float VSqrSum, I1SqrSum, I2SqrSum, PSum;
float I1SqrSum_Temp, I2SqrSum_Temp, VSqrSum_Temp, PSum_Temp;
float I1RMS, I2RMS, VRMS, PAVG;
float timerTop;

void Init (void) {
	// Define Ports
	DDRB  = 0b00101111;
	PORTB = 0b00010010;
	DDRC  = 0b00000000;
	PORTC = 0b00000111;
	DDRD  = 0b11110010;
	PORTD = 0b00001101;
	
	// Animation
	sbi(POWERLED_P,POWERLED);
	_delay_ms(300);
	cbi(POWERLED_P,POWERLED);
	_delay_ms(300);
	sbi(POWERLED_P,POWERLED);
	_delay_ms(300);
	cbi(POWERLED_P,POWERLED);
	_delay_ms(300);
	
	// Initialize ADC
	//ADCSRA = _BV(ADEN)|_BV(ADIE)|(0b111<<ADPS0);
	//ADMUX = (0b01<<REFS0)|_BV(ADLAR);
	ADMUX=ADC_VREF_TYPE & 0xff;
	ADCSRA=0x84;
	DIDR0 = 0x3F;
	
	// Initialize Interrupt
	MCUCR = (0b10<<ISC10);
	EIMSK = _BV(INT1);
	
	// Initialize SPI
	SPCR = _BV(SPE)|_BV(MSTR);
	
	// Initialize Timer
	TCCR1A = (0b11<<WGM10)|(0b10<<COM1B0);
	TCCR1B = (0b11<<WGM12)|(0b101<<CS10);
	OCR1AH = 255;
	OCR1AL = 255;
	OCR1BH = 0;
	OCR1BL = 250;
	
	//Set timer interrupt with frequency 100Hz
  TCCR0A = 0;// set entire TCCR2A register to 0
  TCCR0B = 0;// same for TCCR2B
  TCNT0  = 0;//initialize counter value to 0
  // 1 ms
  OCR0A = 15;// = (16*10^6) / (1000*1024) - 1 (must be <256)
  // turn on CTC mode
  TCCR0A |= (1 << WGM01);
  // Set CS01 and CS00 bits for 1024 prescaler
  TCCR0B |= (1 << CS02) | (1 << CS00);   
  // enable timer compare interrupt
  TIMSK0 |= (1 << OCIE0A);
	
	// Initialize USART
	UCSR0A=0x00;
	UCSR0B=0x08;
	UCSR0C=0x06;
	UBRR0H=0x00;
	UBRR0L=0x67;
	
	// Global Interrupt Enable
	sei();
	
	// Variable Initialization
	readFlag = 0;
	switchState = 1;
	sbi(POWERLED_P,POWERLED);
	ADCCount = 3;
	ADCSRA |= _BV(ADSC);
}

unsigned int read_adc (unsigned char channel) {

	union ADCValue {
		int i;
		char c[2];
	} ADCValue;
	
	/*
	ADCValue.c[0] = ADCH;
	ADCValue.c[1] = ADCL;
	UDR0 = ADCH;
	ADMUX |= channel;
	_delay_us(10);
    ADCSRA |= _BV(ADSC);				// Start the AD conversion
	*/
	
	ADMUX=channel | (ADC_VREF_TYPE & 0xff);
	// Delay needed for the stabilization of the ADC input voltage
	_delay_us(10);
	// Start the AD conversion
	ADCSRA|=0x40;
	// Wait for the AD conversion to complete
	while ((ADCSRA & 0x10)==0);
	ADCSRA|=0x10;
	ADCValue.c[1] = ADCL;
	ADCValue.c[0] = ADCH;
	UDR0 = ADCH;
	return ADCValue.i;
}

char WriteByteSPI (unsigned char cData) {
	SPDR = cData;
	while (!(SPSR & BIT(SPIF)));
	return SPDR;
}

uint8_t NRF_GetReg (uint8_t reg) {
	_delay_us(10);
	CLEARBIT(CSN_P,CSN);
	_delay_us(10);
	WriteByteSPI(R_REGISTER + reg);
	_delay_us(10);
	reg = WriteByteSPI(NOP);
	_delay_us(10);
	SETBIT(CSN_P,CSN);
	return reg;
}

void NRF_WriteReg (uint8_t reg, uint8_t Package) {
	_delay_us(10);
	CLEARBIT(CSN_P,CSN);
	_delay_us(10);
	WriteByteSPI(W_REGISTER + reg);
	_delay_us(10);
	WriteByteSPI(Package);
	_delay_us(10);
	SETBIT(CSN_P,CSN);
}

uint8_t *NRF_Write (uint8_t ReadWrite, uint8_t reg, uint8_t *val, uint8_t antVal) {
	if (ReadWrite == W) {
		reg = W_REGISTER + reg;
	}
	
	static uint8_t ret[32];
	
	_delay_us(10);
	CLEARBIT(CSN_P,CSN);
	_delay_us(10);
	WriteByteSPI(reg);
	_delay_us(10);
	
	int i;
	for (i=0;i<antVal;i++) {
		if ((ReadWrite == R) && (reg != W_TX_PAYLOAD)) {
			ret[i] = WriteByteSPI(NOP);
			_delay_us(10);
		} else {
			WriteByteSPI(val[i]);
			_delay_us(10);
		}
	}
	SETBIT(CSN_P,CSN);
	
	return ret;
}

void NRF_Init (void) {
	_delay_ms(100);
	
	uint8_t val[5];
	
	val[0] = 0x01;
	NRF_Write(W,EN_AA,val,1);
	
	val[0] = 0x01;
	NRF_Write(W,EN_RXADDR,val,1);
	
	val[0] = 0x03;
	NRF_Write(W,SETUP_AW,val,1);
	
	val[0] = 0x01;
	NRF_Write(W,RF_CH,val,1);
	
	val[0] = 0x07;
	NRF_Write(W,RF_SETUP,val,1);
	
	int i;
	for (i=0;i<5;i++) {
		val[i]=0x12;
	}
	NRF_Write(W,RX_ADDR_P0,val,5);
	
	for (i=0;i<5;i++) {
		val[i]=0x12;
	}
	NRF_Write(W,TX_ADDR,val,5);
	
	val[0] = 5;
	NRF_Write(W,RX_PW_P0,val,1);
	
	val[0] = 0x1E;
	NRF_Write(W,CONFIG,val,1);
	
	_delay_ms(100);
}

void NRF_TransmitPayload (uint8_t *W_buff) {
	NRF_Write(R,FLUSH_TX,W_buff,0);
	NRF_Write(R,W_TX_PAYLOAD,W_buff,5);
	
	_delay_ms(10);
	SETBIT(CSN_P,CSN);
	_delay_ms(20);
	CLEARBIT(CSN_P,CSN);
	_delay_ms(10);
}

void NRF_ReceivePayload (void) {
	SETBIT(CSN_P,CSN);
	_delay_ms(1000);
	CLEARBIT(CSN_P,CSN);
}

void NRF_Reset (void) {
	_delay_ms(10);
	CLEARBIT(CSN_P,CSN);
	_delay_ms(10);
	WriteByteSPI(W_REGISTER + STATUS);
	_delay_ms(10);
	WriteByteSPI(0x70);
	_delay_ms(10);
	SETBIT(CSN_P,CSN);
}

void ReadVI (void) {
	
	switch (ADCCount) {
		case 3 :
			I1Temp = read_adc(++ADCCount); break;
		case 4 : VTemp = read_adc(++ADCCount); break;
		case 5 :
			ADCCount = 3;
			I2Temp = read_adc(ADCCount);
			VRaw = (VTemp-128)*4.31640625;		// Normalize : (VTemp-512)*221*5/1024
			I1Raw = (-0.029296875*I1Raw)+2.5;		// Normalize : (-1.5*I1Raw*5/1024)+2.5
			I2Raw = (-0.029296875*I2Raw)+2.5;		// Normalize : (-1.5*I2Raw*5/1024)+2.5
			UDR0 = (unsigned char) VRaw;
			I1Sqr = I1Raw*I1Raw;
			I2Sqr = I2Raw*I2Raw;
			VSqrSum += VRaw*VRaw;
			I1SqrSum += I1Sqr;
			I2SqrSum += I2Sqr;
			if (abs(I1Sqr) > abs(I2Sqr))
				PSum += I1Sqr;
			else
				PSum += I2Sqr;
			sample++;
			break;
	}
	
}

void Calculate (void) {
	I1SqrSum_Temp = I1SqrSum;
	I2SqrSum_Temp = I2SqrSum;
	VSqrSum_Temp = VSqrSum;
	PSum_Temp = PSum;
	sample_Temp = sample;
	I1SqrSum = 0;
	I2SqrSum = 0;
	VSqrSum = 0;
	PSum = 0;
	sample = 0;
	I1RMS = sqrt(I1SqrSum_Temp/sample_Temp);
	I2RMS = sqrt(I2SqrSum_Temp/sample_Temp);
	VRMS = sqrt(VSqrSum_Temp/sample_Temp);
	PAVG = sqrt(PSum_Temp/sample_Temp);
	if (PAVG!=0)
		timerTop = (59400/PAVG) + 250;
	OCR1AH = (unsigned char) ((unsigned int) (timerTop) >> 8);
	OCR1AL = (unsigned char) ((unsigned int) (timerTop) & 0xFF);
}

ISR (TIMER0_COMPA_vect) {
	ReadVI();
}

ISR (INT0_vect, ISR_NOBLOCK) {
	readFlag = 1;
}

int main (void) {

	unsigned char rData, tData[13];
	union hybrid {
		float f;
		int i[2];
		char c[4];
	} VRMS_, I1RMS_, I2RMS_, PAVG_;

	// Initialization
	Init();
	NRF_Init();
	
	// Enable Rx Mode
	NRF_WriteReg(CONFIG, BIT(EN_CRC) + BIT(PWR_UP) + BIT(PRIM_RX));
	
	while (1) {
		if (sample >= 20000) {
			Calculate();
		}
	
		if (readFlag) {
			NRF_Write(R, R_RX_PAYLOAD, &rData, 1);
			switchState = rData & 0x01;
			loadData = rData & 0x80;
			if (switchState == 1)
				sbi(RELAY_P,RELAY);
			else
				cbi(RELAY_P,RELAY);
		}
		
		if (loadData) {
			
			VRMS_.f = VRMS;
			tData[12] = VRMS_.c[0];
			tData[11] = VRMS_.c[1];
			tData[10] = VRMS_.c[2];
			tData[9] = VRMS_.c[3];
			
			if (I1RMS > I2RMS) {
				I1RMS_.f = I1RMS;
				tData[8] = I1RMS_.c[0];
				tData[7] = I1RMS_.c[1];
				tData[6] = I1RMS_.c[2];
				tData[5] = I1RMS_.c[3];
			} else {
				I2RMS_.f = I2RMS;
				tData[8] = I2RMS_.c[0];
				tData[7] = I2RMS_.c[1];
				tData[6] = I2RMS_.c[2];
				tData[5] = I2RMS_.c[3];
			}
			
			PAVG_.f = PAVG;
			tData[4] = PAVG_.c[0];
			tData[3] = PAVG_.c[1];
			tData[2] = PAVG_.c[2];
			tData[1] = PAVG_.c[3];
			
			tData[0] = switchState;
			
			NRF_Write(R, W_TX_PAYLOAD, tData, 13);
		}
	
	}
}