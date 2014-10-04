import MySQLdb
import random

db = MySQLdb.connect("localhost", "monitor", "smartsocket", "temps")
curs=db.cursor()

try:

	nsocket = 1

	while nsocket <= 3:	

		teg = 22 * random.random()

		arus = 1 * random.random()

		pf = 1 * random.random()

		params = ['S00'+str(nsocket), teg, arus, teg * arus, pf]
		curs.execute("INSERT INTO powerlog VALUES (CURRENT_TIMESTAMP(),%s, %s, %s, %s, %s)", params)
  		nsocket += 1
		db.commit()
	print "All data committed"

except:
	print "Error: the database is being rolled back"
	db.rollback()



db.close()
