import sqlite3
import sys
# from timeit import default_timer as timer

# start = timer()

conn = sqlite3.connect('database/SMP.db')
c = conn.cursor()

username = sys.argv[1]

query = "DELETE FROM BD_MEALS WHERE USER_NAME = '"+ username +"'"
c.execute(query)

query = "SELECT MEAL_PREF, TARGET_CAL FROM USER_INFO WHERE USER_NAME = '"+ username +"'"
c.execute(query)
bmr = c.fetchall()

mealpref = bmr[0][0]
target_calories = bmr[0][1]

carbs_percentage = 62
protein_percentage = 13
fat_percentage = 25
tolerance = 50

for i in range (1, 11, 1):
    
    current_variance = 50
    current_breakfast = current_lunch = current_dinner = current_snack = None
    
    if (mealpref == 'VEG'):
    
        query = "SELECT A.ID, A.TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, RANK FROM FOODS A, ML_BD B \
                    WHERE A.TITLE = B.TITLE AND MEAL_PREF = 'VEG' AND \
                    A.TITLE IN (SELECT TITLE FROM ML_BD WHERE MEAL_TYPE = 'BF' AND USER_NAME = '"+ username +"' AND RANK >= 0) \
                    AND A.TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    UNION ALL \
                    SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, 0 AS RANK FROM FOODS \
                    WHERE MEAL_TYPE = 'BF' AND MEAL_PREF = 'VEG' AND TITLE NOT IN (SELECT TITLE FROM ML_BD) \
                    AND TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    ORDER BY RANK DESC, USER_RATING DESC"
                    
        c.execute(query)
        meals_breakfast = c.fetchall()
        
        query = "SELECT A.ID, A.TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, RANK FROM FOODS A, ML_BD B \
                    WHERE A.TITLE = B.TITLE AND MEAL_PREF = 'VEG' AND \
                    A.TITLE IN (SELECT TITLE FROM ML_BD WHERE MEAL_TYPE = 'LN' AND USER_NAME = '"+ username +"' AND RANK >= 0) \
                    AND A.TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    UNION ALL \
                    SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, 0 AS RANK FROM FOODS \
                    WHERE MEAL_TYPE = 'LN' AND MEAL_PREF = 'VEG' AND TITLE NOT IN (SELECT TITLE FROM ML_BD) \
                    AND TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    ORDER BY RANK DESC, USER_RATING DESC"
                    
        c.execute(query)
        meals_lunch = c.fetchall()

        query = "SELECT A.ID, A.TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, RANK FROM FOODS A, ML_BD B \
                    WHERE A.TITLE = B.TITLE AND MEAL_PREF = 'VEG' AND \
                    A.TITLE IN (SELECT TITLE FROM ML_BD WHERE MEAL_TYPE = 'DN' AND USER_NAME = '"+ username +"' AND RANK >= 0) \
                    AND A.TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    UNION ALL \
                    SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, 0 AS RANK FROM FOODS \
                    WHERE MEAL_TYPE = 'DN' AND MEAL_PREF = 'VEG' AND TITLE NOT IN (SELECT TITLE FROM ML_BD) \
                    AND TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    ORDER BY RANK DESC, USER_RATING DESC"
                    
        c.execute(query)
        meals_dinner = c.fetchall()
        
        query = "SELECT A.ID, A.TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, RANK FROM FOODS A, ML_BD B \
                    WHERE A.TITLE = B.TITLE AND MEAL_PREF = 'VEG' AND \
                    A.TITLE IN (SELECT TITLE FROM ML_BD WHERE MEAL_TYPE = 'SN' AND USER_NAME = '"+ username +"' AND RANK >= 0) \
                    AND A.TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    UNION ALL \
                    SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, 0 AS RANK FROM FOODS \
                    WHERE MEAL_TYPE = 'SN' AND MEAL_PREF = 'VEG' AND TITLE NOT IN (SELECT TITLE FROM ML_BD) \
                    AND TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    ORDER BY RANK DESC, USER_RATING DESC"
                    
        c.execute(query)
        meals_snack = c.fetchall()
        
    else:
        
        query = "SELECT A.ID, A.TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, RANK FROM FOODS A, ML_BD B \
                    WHERE A.TITLE = B.TITLE AND \
                    A.TITLE IN (SELECT TITLE FROM ML_BD WHERE MEAL_TYPE = 'BF' AND USER_NAME = '"+ username +"' AND RANK >= 0) \
                    AND A.TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    UNION ALL \
                    SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, 0 AS RANK FROM FOODS \
                    WHERE MEAL_TYPE = 'BF' AND TITLE NOT IN (SELECT TITLE FROM ML_BD) \
                    AND TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    ORDER BY RANK DESC, USER_RATING DESC"
                    
        c.execute(query)
        meals_breakfast = c.fetchall()
        
        query = "SELECT A.ID, A.TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, RANK FROM FOODS A, ML_BD B \
                    WHERE A.TITLE = B.TITLE AND \
                    A.TITLE IN (SELECT TITLE FROM ML_BD WHERE MEAL_TYPE = 'LN' AND USER_NAME = '"+ username +"' AND RANK >= 0) \
                    AND A.TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    UNION ALL \
                    SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, 0 AS RANK FROM FOODS \
                    WHERE MEAL_TYPE = 'LN' AND TITLE NOT IN (SELECT TITLE FROM ML_BD) \
                    AND TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    ORDER BY RANK DESC, USER_RATING DESC"
        
        c.execute(query)
        meals_lunch = c.fetchall()

        query = "SELECT A.ID, A.TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, RANK FROM FOODS A, ML_BD B \
                    WHERE A.TITLE = B.TITLE AND \
                    A.TITLE IN (SELECT TITLE FROM ML_BD WHERE MEAL_TYPE = 'DN' AND USER_NAME = '"+ username +"' AND RANK >= 0) \
                    AND A.TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    UNION ALL \
                    SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, 0 AS RANK FROM FOODS \
                    WHERE MEAL_TYPE = 'DN' AND TITLE NOT IN (SELECT TITLE FROM ML_BD) \
                    AND TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    ORDER BY RANK DESC, USER_RATING DESC"
        
        c.execute(query)
        meals_dinner = c.fetchall()
        
        query = "SELECT A.ID, A.TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, RANK FROM FOODS A, ML_BD B \
                    WHERE A.TITLE = B.TITLE AND \
                    A.TITLE IN (SELECT TITLE FROM ML_BD WHERE MEAL_TYPE = 'SN' AND USER_NAME = '"+ username +"' AND RANK >= 0) \
                    AND A.TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    UNION ALL \
                    SELECT ID, TITLE, CARBS, PROTEIN, FAT, CALORIES, USER_RATING, 0 AS RANK FROM FOODS \
                    WHERE MEAL_TYPE = 'SN' AND TITLE NOT IN (SELECT TITLE FROM ML_BD) \
                    AND TITLE NOT IN (SELECT TITLE FROM BD_MEALS WHERE USER_NAME = '"+ username +"') \
                    ORDER BY RANK DESC, USER_RATING DESC"
        
        c.execute(query)
        meals_snack = c.fetchall()

    for bf in meals_breakfast:
        for ln in meals_lunch:
            for dn in meals_dinner:
                for sn in meals_snack:
                
                    carbs_calories = (bf[2] * 4) + (ln[2] * 4) + (dn[2] * 4) + (sn[2] * 4)
                    protein_calories = (bf[3] * 4) + (ln[3] * 4) + (dn[3] * 4) + (sn[3] * 4)
                    fat_calories = (bf[4] * 9) + (ln[4] * 9) + (dn[4] * 9) + (sn[4] * 9)
                    
                    total_calories = carbs_calories + protein_calories + fat_calories
                
                    if (total_calories < (target_calories - tolerance)) or (total_calories > (target_calories + tolerance)):
                        continue            
                    
                    carbs_ratio = carbs_calories / total_calories * 100
                    protein_ratio = protein_calories / total_calories * 100
                    fat_ratio = fat_calories / total_calories * 100
                    
                    total_variance = abs(carbs_ratio - carbs_percentage) + abs(protein_ratio - protein_percentage) + abs(fat_ratio - fat_percentage)
                    
                    if (total_variance > 5):
                        continue
                    
                    if (total_variance < current_variance):
                        current_variance = total_variance
                        current_breakfast = bf
                        current_lunch = ln
                        current_dinner = dn
                        current_snack = sn
                        
                    if (total_variance < 5):
                        break
                else:
                    continue
                break
            else:
                continue
            break
        else:
            continue
        break

    if (current_breakfast and current_lunch and current_dinner and current_snack):
        # print (current_breakfast)
        # print (current_lunch)
        # print (current_dinner)
        # print (current_snack)
        # print (current_variance)
                
        query = "INSERT INTO BD_MEALS (USER_NAME, TITLE, CALORIES, CARBS, PROTEIN, FAT, MEAL_TYPE, DAY) \
                    VALUES ('"+ username +"', '"+ current_breakfast[1] +"', "+ str(current_breakfast[5]) +", "+ str(current_breakfast[2]) +", " \
                    + str(current_breakfast[3]) +", "+ str(current_breakfast[4]) +", 'BF', "+ str(i) +")" 
        # print (query)
        c.execute(query)
                    
        query = "INSERT INTO BD_MEALS (USER_NAME, TITLE, CALORIES, CARBS, PROTEIN, FAT, MEAL_TYPE, DAY) \
                    VALUES ('"+ username +"', '"+ current_lunch[1] +"', "+ str(current_lunch[5]) +", "+ str(current_lunch[2]) +", " \
                    + str(current_lunch[3]) +", "+ str(current_lunch[4]) +", 'LN', "+ str(i) +")"
        # print (query) 
        c.execute(query)
        
        query = "INSERT INTO BD_MEALS (USER_NAME, TITLE, CALORIES, CARBS, PROTEIN, FAT, MEAL_TYPE, DAY) \
                    VALUES ('"+ username +"', '"+ current_snack[1] +"', "+ str(current_snack[5]) +", "+ str(current_snack[2]) +", " \
                    + str(current_snack[3]) +", "+ str(current_snack[4]) +", 'SN', "+ str(i) +")" 
        # print (query)
        c.execute(query)

        query = "INSERT INTO BD_MEALS (USER_NAME, TITLE, CALORIES, CARBS, PROTEIN, FAT, MEAL_TYPE, DAY) \
                    VALUES ('"+ username +"', '"+ current_dinner[1] +"', "+ str(current_dinner[5]) +", "+ str(current_dinner[2]) +", " \
                    + str(current_dinner[3]) +", "+ str(current_dinner[4]) +", 'DN', "+ str(i) +")" 
        # print (query)
        c.execute(query)
        
        conn.commit()
    
conn.close()

# print ('Done')

# end = timer()
# print (round(end - start, 1), 's')