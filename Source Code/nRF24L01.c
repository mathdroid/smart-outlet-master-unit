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

void NRF_Write (uint8_t reg, uint8_t Package) {
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
	NRF_Write(W,TX_ADDR_P0,val,5);
	
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