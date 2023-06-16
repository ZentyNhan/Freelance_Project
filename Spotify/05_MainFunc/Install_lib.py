import os
libs = ['pyvirtualdisplay',
        'webdriver-manager',
        'pickle',
        'subprocess',
        'selenium',
        'time',
        'sys',
        'datetime',
        'requests',
        'json',
        'pypyodbc',
        'pyodbc']

for lib in libs:
    os.system('pip install ' + lib)

print('\n---------- COMPLETED ----------')
input()