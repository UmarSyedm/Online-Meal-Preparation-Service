import sqlite3
import sys
from timeit import default_timer as timer

start = timer()

conn = sqlite3.connect('database/SMP.db')
c = conn.cursor()

if len (sys.argv) < 2:
    
    query = "SELECT USER_NAME, MEAL_PREF, TARGET_CAL FROM USER_INFO"
    print(query)

elif len (sys.argv) == 2:
    
    username = sys.argv[1]
    query = "SELECT USER_NAME, MEAL_PREF, TARGET_CAL FROM USER_INFO WHERE USER_NAME = '"+ username +"'"
    print(query)

else:
    print("Stop")
    sys.exit()

