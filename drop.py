import sqlite3
from tabulate import tabulate

# Connect to the SQLite database
conn = sqlite3.connect('task_manager')
cursor = conn.cursor()


try:
    query = '''DROP TABLE personal_access_tokens;'''

    cursor.execute(query)
    conn.commit()
except Exception as e:
    print(e)


# Close the database connection
conn.close()


