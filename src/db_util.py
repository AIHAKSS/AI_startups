#!/usr/bin/python

import MySQLdb
# http://mysql-python.sourceforge.net/MySQLdb.html#mysqldb

# Open database connection
_db = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")


def get_shares(stock_no, date_str):
    cursor = _db.cursor()
    sql = "SELECT ashares FROM xkx.tb_structinfo where stockno='%s' and date<='%s' order by date desc limit 1;" % (stock_no, date_str)
    try:
        cursor.execute(sql)
        results = cursor.fetchall()
        for row in results:
            cursor.close()
            return row[0]
    except:
        cursor.close()
        return 0 
    cursor.close()
    return 0 

def get_daily_args(stock_no, date_str):
    cursor = _db.cursor()
    sql = "SELECT open, close, high, low, volume, turnover FROM xkx.tb_dailyprice where stockno='%s' and date>'%s';" % (stock_no, date_str)
    try:
        cursor.execute(sql)
        results = cursor.fetchall()
        for row in results:
            cursor.close()
            return row
    except:
        cursor.close()
        return [] 
    cursor.close()
    return [] 


def test():
    print get_shares('600000', '2014-09-12')
    print get_daily_args('600000', '2014-09-12')


if __name__ == '__main__':
    test()
