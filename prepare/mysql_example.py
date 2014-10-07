#!/usr/bin/python

import MySQLdb
# http://mysql-python.sourceforge.net/MySQLdb.html#mysqldb

# Open database connection
db = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")

# prepare a cursor object using cursor() method
cursor = db.cursor()

# execute SQL query using execute() method.
#cursor.execute("SELECT VERSION()")
# Fetch a single row using fetchone() method.
#data = cursor.fetchone()
#print "Database version : %s " % data

sql = "SELECT open, close, high, low, volume, turnover, turnoverrate FROM xkx.tb_dailyprice where stockno='600000' and date>'2014-09-01';"
try:
    cursor.execute(sql)
    results = cursor.fetchall()
    for row in results:
        print row[0], row[1], row[2], row[3], row[4], row[5], row[6] 
except:
    print 'fetch error'


'''
# Prepare SQL query to INSERT a record into the database.
sql = "INSERT INTO EMPLOYEE(FIRST_NAME, \
        LAST_NAME, AGE, SEX, INCOME) \
        VALUES ('%s', '%s', '%d', '%c', '%d' )" % \
        ('Mac', 'Mohan', 20, 'M', 2000)
try:
    # Execute the SQL command
    cursor.execute(sql)
    # Commit your changes in the database
    db.commit()
except:
    # Rollback in case there is any error
    db.rollback()

# Prepare SQL query to INSERT a record into the database.
sql = "SELECT * FROM EMPLOYEE \
        WHERE INCOME > '%d'" % (1000)
try:
    # Execute the SQL command
    cursor.execute(sql)
    # Fetch all the rows in a list of lists.
    results = cursor.fetchall()
    for row in results:
        fname = row[0]
        lname = row[1]
        age = row[2]
        sex = row[3]
        income = row[4]
        # Now print fetched result
        print "fname=%s,lname=%s,age=%d,sex=%s,income=%d" % \
                (fname, lname, age, sex, income )
except:
    print "Error: unable to fecth data"
'''

# disconnect from server
db.close()
