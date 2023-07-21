import os
libs = ['pyvirtualdisplay',
        'webdriver-manager',
        'pickle',
        'subprocess',
        'selenium',
        'selenium-wire',
        'time',
        'multipledispatch',
        'xlsxwriter',
        'sys',
        'io',
        'django',
        'termcolor',
        'random',
        'datetime',
        'requests',
        'json',
        'tablib',
        'pypyodbc',
        'pyodbc']

for lib in libs:
    os.system('pip install ' + lib)

print('\n---------- COMPLETED ----------')
input()