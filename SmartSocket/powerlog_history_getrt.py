#powerlog_history_getrt.py
#Muhammad Mustadi 14 Oct 2014
#get rt data for the table powerlog_history, from table powerlog_rt. crontab every 15 minutes.




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
		#params = [nsocket, 51.2, 21.5]
		curs.execute("INSERT INTO powerlog_history (timestamp, sid, kwh, budget) SELECT timestamp, sid, daya*0.25, daya*0.25*605 FROM powerlog_rt WHERE sid=%s", nsocket)
  		#source http://pulsa-online.com/wp-content/uploads/2013/10/Tarif-Tenaga-Listrik-2013.jpg
  		nsocket += 1
		db.commit()
	print "All data committed"

except:
	print "Error: the database is being rolled back"
	db.rollback()



db.close()
