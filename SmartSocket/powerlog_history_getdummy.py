#powerlog_history_getdummy.py
#Muhammad Mustadi 4 Oct 2014
#get dummy data for the table powerlog_history. crontab every 15 minutes.




import MySQLdb
import random

#connect to smart_smartsocket
db = MySQLdb.connect("localhost", "monitor", "smartsocket", "smart_smartsocket")
curs=db.cursor()

try:

	nsocket = 1

	while nsocket <= 3:	

		#teg = 22 * random.random()

		#arus = 1 * random.random()

		#pf = 1 * random.random()
		
		#powerlog_history is (timestamp, sid, kwh, budget)
		#powerlog_history is (datetime, tinyint(3),float,float)
		#old - params = ['S00'+str(nsocket), teg, arus, teg * arus, pf]
		params = [nsocket, 51.2, 21.5]
		

		curs.execute("INSERT INTO powerlog_history VALUES (CURRENT_TIMESTAMP(),%s, %s, %s)", params)
  		nsocket += 1
		db.commit()
	print "All data committed"

except:
	print "Error: the database is being rolled back"
	db.rollback()



db.close()
