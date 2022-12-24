########## SECTION: Library ##########
from ast import Try, keyword
from contextlib import nullcontext
from lib2to3.pgen2.literals import test
import os
from pickle import FALSE, TRUE
from subprocess import check_output
from inspect import currentframe
from typing import List
from xml.etree.ElementTree import QName
from selenium import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.select import Select
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import NoSuchElementException,ElementNotInteractableException
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from datetime import datetime
from datetime import date
import requests
from termcolor import colored 
from selenium import webdriver
from selenium.webdriver.chrome.options import Options

#Excel Processing:
from openpyxl import Workbook 
from openpyxl.worksheet.worksheet import Worksheet
from openpyxl import load_workbook
from openpyxl.utils import get_column_letter
from openpyxl.styles import Alignment, Font,PatternFill,Border,Side

#pypyodbc:
import pypyodbc as odbc
import pyodbc

DRIVER_NAME = 'ODBC Driver 17 for SQL Server'
SERVER_NAME = 'DESKTOP-RCFES7K\SQLEXPRESS'
DATABASE_NAME = 'SpotifyUpgrade_DB'

connection = f'''
        DRIVER={DRIVER_NAME};
        SERVER={SERVER_NAME};
        DATABASE={DATABASE_NAME};
        UID=Thanhnhan19;
        PWD=Nhan0334842024;
'''
#connect to database:
conn = pyodbc.connect(connection)

#use cursor:
cursor = conn.cursor()

#Extract data from
#Local var
Email = []
PassW = []

for row in cursor.execute('select * from Customer_Infor'):
        Email.append(row.EmailAddress)
        PassW.append(row.EmailPW)

print('Email: ',Email[0])
print('PassW: ',PassW[0])

driver = webdriver.Chrome('chromedriver.exe')
url = 'https://whoer.net/fr'
#Get link:
driver.get(url)

url = f'https://accounts.spotify.com/vi-VN/login?continue=https%3A%2F%2Fopen.spotify.com%2F'
#Get link:
driver.get(url)

driver.maximize_window()
sleep(3)
driver.find_element(By.ID ,'login-username').send_keys(Email[0])
driver.find_element(By.ID ,'login-password').send_keys(PassW[0])
driver.find_element(By.ID ,'login-button').click()
sleep(3)
driver.get('https://www.spotify.com/tr/account/profile/')
sleep(3)
select = Select(driver.find_element(By.ID, 'country'))
select.select_by_value('TR')

driver.find_element(By.XPATH, '''//body/div[@id='__next']/div[1]/div[1]/div[2]/div[2]/div[2]/div[1]/article[1]/section[1]/form[1]/div[1]/button[1]''').click()


input('Press any key to break')






















# PROXY = "188.132.222.22:8080"
# chrome_options = webdriver.ChromeOptions()
# chrome_options.add_argument('--proxy-server=%s' % PROXY)
# chrome = webdriver.Chrome(chrome_options=chrome_options)
# chrome.get("https://whoer.net/fr")
# sleep(30)


