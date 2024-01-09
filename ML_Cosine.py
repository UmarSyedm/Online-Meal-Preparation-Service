import sys
import sqlite3
from sklearn.metrics.pairwise import cosine_similarity

con = sqlite3.connect("database/SMP.db")

cur = con.cursor()
cur.execute('SELECT ID, TITLE, CALORIES, CARBS, PROTEIN, FAT, SUGAR, FIBER, SODIUM FROM FOODS WHERE ML_RATING IS NULL;')
rows = cur.fetchall()

if len(rows) == 0 :
    sys.exit("No Rows found... Exiting")

print ('Found ' + str(len(rows)) + ' Rows and working with the first row')

cur.execute('SELECT ID, TITLE, CALORIES, CARBS, PROTEIN, FAT, SUGAR, FIBER, SODIUM FROM FOODS WHERE ML_RATING IS NULL;')
newrow = cur.fetchall()[0]
print ('Analysing Meal - ' + str(newrow))
mealnew = [newrow[2], newrow[3], newrow[4], newrow[5], newrow[6], newrow[7],newrow[8]]

cur = con.cursor()
rows = cur.execute('SELECT ID, TITLE, CALORIES, CARBS, PROTEIN, FAT, SUGAR, FIBER, SODIUM, USER_RATING FROM FOODS WHERE ML_RATING IS NOT NULL;')
diff = 0

for row in rows:
    meal = [row[2], row[3], row[4], row[5], row[6], row[7], row[8]]
    cosine_sim = cosine_similarity([mealnew], [meal])

    if cosine_sim[0][0] > diff :
        diff = cosine_sim[0][0]
        title = row[1]
        selrow = row

# print (title, diff)

print (selrow)

updsql = '''UPDATE FOODS SET ML_RATING = ''' + str(selrow[9]) + ''' WHERE ID = ''' + str(newrow[0]) +''';'''

print ("Cosine Similarity value:", diff)

cur.execute(updsql)
con.commit()

con.close()