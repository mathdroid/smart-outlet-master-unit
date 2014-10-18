#include "nRF24L01.h"
#include "SPI.h"
#include <math.h>

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
#define RELAY 2
#define RELAY_P PORTD
#define RFDATA1 0
#define RFDATA1_P PORTB
#define RFDATA2 1
#define RFDATA2_P PORTB
#define RFIRQ 3
#define RFIRQ_P PORTD

// Receive Bytes :  
// Byte 0 - Commands
//  Bit 7 - Load Data
//  Bit 1 - Light
//  Bit 0 - Switch

// Transmit Bytes :
// Byte 12..9 - Voltage Reading
// Byte 8..5 - Current Reading
// Byte 4..1 - Power Reading
// Byte 0 :
//  Bit 1 - Light State
//  Bit 0 - Switch State

// Timer :
// Energy Pulse

// ADC : Free Running, Interrupt Enabled

// To do : Light State, Switch State Indicator

void Init () {
	// Define Ports
	DDRB  = 0b00101111;
	PORTB = 0b00010000;
	DDRC  = 0b00000000;
	PORTC = 0b00000111;
	DDRD  = 0b11110010;
	PORTD = 0b00001101;
	
	// Initialize ADC
	ADCSRA = _BV(ADEN)|_BV(ADSC)|_BV(ADFR)|_BV(ADIE)|(0b100<<ADPS0);
	ADMUX = (0b01<<REFS0);
	
	// Initialize Interrupt
	MCUCR = (0b10<<ISC10);
	GICR = _BV(INT1);
	
	// Initialize SPI
	SPCR = _BV(SPE)|_BV(MSTR);
	
	// Initialize Timer
	TCCR1A = (0b11<<WGM10)|(0b10<<COM1B0);
	TCCR1B = (0b11<<WGM12)|(0b101<<CS10);
	OCR1BH = 0;
	OCR1BL = 250;
	
	// Global Interrupt Enable
	sei();

}

void ReadVI () {
	VTemp = read_adc(V_ADC);
	I1Temp = read_adc(I1_ADC);
	I2Temp = read_adc(I2_ADC);
	VRaw = 						// Normalize
	I1Raw = 						// Normalize
	I2Raw = 						// Normalize
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
}

void Calculate () {
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
	timerTop = (59400/(unsigned int)PAVG) + 250;
	OCR1AH = unsigned char(timerTop >> 8);
	OCR1AL = unsigned char(timerTop & 0xFF);
}

ISR (ADC_vect) {
	ReadVI();
}

ISR (INT0_vect, ISR_NOBLOCK) {
	readFlag = 1;
}

void main (void) {
	// Initialization
	Init();
	NRF_Init();
	
	// Enable Rx Mode
	NRF_Write(CONFIG, BIT(EN_CRC) + BIT(PWR_UP) + BIT(PRIM_RX));
	
	while (1) {
		if (sample >= 20000) {
			Calculate();
		}
	
		if (readFlag) {
			NRF_Write(R, R_RX_PAYLOAD, rData, 1);
			switchState = rData & 0x01;
			lightState = rData & 0x7E;
			loadData = rData & 0x80;
		}
		
		if (loadData) {
			
			tData[12] = VRMS_[3];
			tData[11] = VRMS_[2];
			tData[10] = VRMS_[1];
			tData[9] = VRMS_[0];
			
			if (I1RMS > I2RMS) {
				tData[8] = I1RMS_[3];
				tData[7] = I1RMS_[2];
				tData[6] = I1RMS_[1];
				tData[5] = I1RMS_[0];
			} else {
				tData[8] = I2RMS_[3];
				tData[7] = I2RMS_[2];
				tData[6] = I2RMS_[1];
				tData[5] = I2RMS_[0];
			}
			
			tData[4] = PAVG_[3];
			tData[3] = PAVG_[2];
			tData[2] = PAVG_[1];
			tData[1] = PAVG_[0];
			
			tData[0] = switchState + lightState;
			
			NRF_Write(R, W_TX_PAYLOAD, tData, 13);
		}
	
	}
}