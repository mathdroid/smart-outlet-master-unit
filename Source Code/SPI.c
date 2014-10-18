void InitSPI (void) {

}

char WriteByteSPI (unsigned char cData) {
	SPDR = cData;
	while (!(SPSR & BIT(SPIF)));
	return SPDR;
}