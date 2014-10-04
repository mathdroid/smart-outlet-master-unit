import MySQLdb
import random
import time

def get_random_voltage():
	return 22*random.random()

def get_random_current():
	return 1 * random.random()

def get_random_pf():
	return 1 - (2 * random.random())
	
time.sleep(10)
# VARIABLES FOR MySQL
db = MySQLdb.connect("localhost", "monitor", "smartsocket", "temps")
curs=db.cursor()

# VARIABLES FOR MySQL Values


# SYSTEM VARIABLES
installedsocket = 3

# INITIALIZATION
nsocket = 1
tempsocket = 1
curs.execute("TRUNCATE TABLE powerrt")
while tempsocket <= installedsocket:
	sname = 'S'+str(tempsocket)
	try:
		curs.execute("INSERT INTO powerrt(sid) VALUES (%s)", sname)
		db.commit()
		print "INIT "+str(tempsocket)+" SUCCESS"
		tempsocket += 1
	except:
		db.rollback()
		print "INIT FAILED"

while True:
	nsocket = 1
	while nsocket <= installedsocket:
		teg = get_random_voltage()
		arus = get_random_current()

		pf = get_random_pf()
		params = [teg, arus, teg*arus,pf]
		nsid = 'S'+str(nsocket)
		try:
			curs.execute("UPDATE powerrt SET tegangan=%s, arus=%s, daya=%s, pf=%s, updatedon=CURRENT_TIMESTAMP() WHERE sid=%s", (teg,arus,teg*arus,pf, nsid))
			db.commit()
			print "DATA COMMITTED"
		except:
			
			print "DATA ROLLED BACK"
		print 'socket id: S'+str(nsocket)
		print 'Voltage : '+str(get_random_voltage())
		nsocket += 1
	time.sleep(2)

#try:
#	nsocket = 1
#	while nsocket <= 3:	
#		teg = 22 * random.random()
#		arus = 1 * random.random()
#		pf = 1 * random.random()

#		params = ['S00'+str(nsocket), teg, arus, teg * arus, pf]
#		curs.execute("INSERT INTO powerlog VALUES (CURRENT_TIMESTAMP(),%s, %s, %s, %s, %s)", params)
 # 		nsocket += 1
#		db.commit()
#	print "All data committed"

#except:
#	print "Error: the database is being rolled back"
#	db.rollback()



#db.close()
