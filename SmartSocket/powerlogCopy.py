import MySQLdb
import random

db = MySQLdb.connect("localhost", "monitor", "smartsocket", "temps")
curs=db.cursor()

try:
#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE() - INTERVAL 1 DAY, NOW(), 's-01', 21.7)")
#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE() - INTERVAL 1 DAY, NOW(), 's-02', 24.5)")
#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE() - INTERVAL 1 DAY, NOW(), 's-03', 18.1)")

#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE() - INTERVAL 12 HOUR, NOW() - interval 12 hour, 's-01', 20.6)")
#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE() - INTERVAL 12 HOUR - interval 12 hour, NOW(), 's-02', 22.8)")
#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE() - INTERVAL 12 HOUR, NOW() - interval 12 hour, 's-03', 16.2)")

#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE(), NOW(), 's-01', 22.9)")
#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE(), NOW(), 's-02', 25.9)")
#	curs.execute("INSERT INTO powdat VALUES (CURRENT_DATE(), NOW(), 's-03', 18.2)")
	nsocket = 1
#	print 'socket id: S00'+str(nsocket)
	while nsocket <= 3:	
		teg = 22 * random.random()
#		print teg
#		print "\n"
		arus = 100 * random.random()
#		print arus
#		print "\n"
		pf = 1 * random.random()
#		print pf
#		print "\n"
		params = ['S00'+str(nsocket), teg, arus, teg * arus, pf]
		curs.execute("INSERT INTO powerlog VALUES (CURRENT_TIMESTAMP(),%s, %s, %s, %s, %s)", params)
  		nsocket += 1
		db.commit()
	print "All data committed"

except:
	print "Error: the database is being rolled back"
	db.rollback()

#curs.execute("SELECT * FROM powdat")

#print "\nDate		Time		Socket		Power"
#print "======================================================="

#for reading in curs.fetchall():
#	print str(reading[0])+"	"+str(reading[1])+"	"+str(reading[2])+"		"+str(reading[3])

db.close()
