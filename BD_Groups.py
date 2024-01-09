'''

'''

import sqlite3
import sys
from timeit import default_timer as timer

start = timer()

conn = sqlite3.connect('database/SMP.db')
c = conn.cursor()

if len (sys.argv) < 2:
    
    query = "SELECT USER_NAME, MEAL_PREF, TARGET_CAL FROM USER_INFO"
    c.execute(query)
    rows = c.fetchall()
    
    deletequery = "DELETE FROM BD_GROUPS"
    c.execute(deletequery)

elif len (sys.argv) == 2:
    
    username = sys.argv[1]
    query = "SELECT USER_NAME, MEAL_PREF, TARGET_CAL FROM USER_INFO WHERE USER_NAME = '"+ username +"'"
    c.execute(query)
    rows = c.fetchall()
    
    deletequery = "DELETE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"'"
    c.execute(deletequery)

else:
    # print("Stop")
    sys.exit()

carbs_percentage = 62
protein_percentage = 13
fat_percentage = 25
cal_tolerance = 30

for row in rows:
    
    username = row[0]
    mealpref = row[1]
    targetcal = row[2]
    
    for i in range (1, 21, 1):        
        
        current_variance = 50
        current_breakfast = current_lunch = current_snack = current_dinner = None
        
        if (mealpref == 'VEG'):
    
            query = "SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES FROM FOODS WHERE MEAL_TYPE = 'BF' AND MEAL_PREF = 'VEG' \
                        AND TITLE NOT IN (SELECT TITLE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"') ORDER BY USER_RATING"
            c.execute(query)
            meals_breakfast = c.fetchall()
            
            query = "SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES FROM FOODS WHERE MEAL_TYPE = 'LN' AND MEAL_PREF = 'VEG' \
                        AND TITLE NOT IN (SELECT TITLE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"') ORDER BY USER_RATING"
            c.execute(query)
            meals_lunch = c.fetchall()

            query = "SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES FROM FOODS WHERE MEAL_TYPE = 'DN' AND MEAL_PREF = 'VEG' \
                        AND TITLE NOT IN (SELECT TITLE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"') ORDER BY USER_RATING"
            c.execute(query)
            meals_dinner = c.fetchall()
            
            query = "SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES FROM FOODS WHERE MEAL_TYPE = 'SN' AND MEAL_PREF = 'VEG' \
                        AND TITLE NOT IN (SELECT TITLE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"') ORDER BY USER_RATING"
            c.execute(query)
            meals_snack = c.fetchall()
        
        else:
            
            query = "SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES FROM FOODS WHERE MEAL_TYPE = 'BF' \
                        AND TITLE NOT IN (SELECT TITLE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"') ORDER BY USER_RATING"
            c.execute(query)
            meals_breakfast = c.fetchall()
            
            query = "SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES FROM FOODS WHERE MEAL_TYPE = 'LN' \
                        AND TITLE NOT IN (SELECT TITLE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"') ORDER BY USER_RATING"
            c.execute(query)
            meals_lunch = c.fetchall()

            query = "SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES FROM FOODS WHERE MEAL_TYPE = 'SN' \
                        AND TITLE NOT IN (SELECT TITLE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"') ORDER BY USER_RATING"
            c.execute(query)
            meals_snack = c.fetchall()
            
            query = "SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES FROM FOODS WHERE MEAL_TYPE = 'DN' \
                        AND TITLE NOT IN (SELECT TITLE FROM BD_GROUPS WHERE USER_NAME = '"+ username +"') ORDER BY USER_RATING"
            c.execute(query)
            meals_dinner = c.fetchall()

        for bf in meals_breakfast:
            for ln in meals_lunch:
                for sn in meals_snack:
                    for dn in meals_dinner:
                    
                        carbs_calories = (bf[2] * 4) + (ln[2] * 4) + (dn[2] * 4) + (sn[2] * 4)
                        protein_calories = (bf[3] * 4) + (ln[3] * 4) + (dn[3] * 4) + (sn[3] * 4)
                        fat_calories = (bf[4] * 9) + (ln[4] * 9) + (dn[4] * 9) + (sn[4] * 9)
                        
                        total_calories = carbs_calories + protein_calories + fat_calories
                    
                        if (total_calories < (targetcal - cal_tolerance)) or (total_calories > (targetcal + cal_tolerance)):
                            continue            
                        
                        carbs_ratio = carbs_calories / total_calories * 100
                        protein_ratio = protein_calories / total_calories * 100
                        fat_ratio = fat_calories / total_calories * 100
                        
                        total_variance = abs(carbs_ratio - carbs_percentage) + abs(protein_ratio - protein_percentage) + abs(fat_ratio - fat_percentage)
                        
                        if (total_variance > 10):
                            continue
                        
                        if (total_variance < current_variance):
                            current_variance = total_variance
                            current_breakfast = bf
                            current_lunch = ln
                            current_snack = sn
                            current_dinner = dn

        if (current_breakfast and current_lunch and current_dinner and current_snack):
            # print (username, i)
            # print (current_breakfast)
            # print (current_lunch)
            # print (current_snack)
            # print (current_dinner)
            # print (current_variance)
                    
            query = "INSERT INTO BD_GROUPS (USER_NAME, TITLE, CALORIES, CARBS, PROTEIN, FAT, MEAL_TYPE, RANK, DAY_INDEX) \
                        VALUES ('"+ username +"', '"+ current_breakfast[1] +"', "+ str(current_breakfast[5]) +", "+ str(current_breakfast[2]) +", " \
                        + str(current_breakfast[3]) +", "+ str(current_breakfast[4]) +", 'BF', '0', "+ str(i) +")" 
            # print (query)
            c.execute(query)
                        
            query = "INSERT INTO BD_GROUPS (USER_NAME, TITLE, CALORIES, CARBS, PROTEIN, FAT, MEAL_TYPE, RANK, DAY_INDEX) \
                        VALUES ('"+ username +"', '"+ current_lunch[1] +"', "+ str(current_lunch[5]) +", "+ str(current_lunch[2]) +", " \
                        + str(current_lunch[3]) +", "+ str(current_lunch[4]) +", 'LN', '0', "+ str(i) +")"
            # print (query) 
            c.execute(query)
            
            query = "INSERT INTO BD_GROUPS (USER_NAME, TITLE, CALORIES, CARBS, PROTEIN, FAT, MEAL_TYPE, RANK, DAY_INDEX) \
                        VALUES ('"+ username +"', '"+ current_snack[1] +"', "+ str(current_snack[5]) +", "+ str(current_snack[2]) +", " \
                        + str(current_snack[3]) +", "+ str(current_snack[4]) +", 'SN', '0', "+ str(i) +")" 
            # print (query)
            c.execute(query)

            query = "INSERT INTO BD_GROUPS (USER_NAME, TITLE, CALORIES, CARBS, PROTEIN, FAT, MEAL_TYPE, RANK, DAY_INDEX) \
                        VALUES ('"+ username +"', '"+ current_dinner[1] +"', "+ str(current_dinner[5]) +", "+ str(current_dinner[2]) +", " \
                        + str(current_dinner[3]) +", "+ str(current_dinner[4]) +", 'DN', '0', "+ str(i) +")" 
            # print (query)
            c.execute(query)
            
            conn.commit()

conn.close()

# print ('Done')

# end = timer()
# print (round(end - start, 1), 's')
# print (round((end - start)/60, 1), 'min')