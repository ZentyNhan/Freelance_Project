########## SECTION: Library ##########
from ast import Try, keyword
from contextlib import nullcontext
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

#MySQL:
import mysql.connector
from mysql.connector import Error


try:
    connection = mysql.connector.connect(host='localhost',
                                         database='Electronics',
                                         user='pynative',
                                         password='pynative@#29')
    if connection.is_connected():
        db_Info = connection.get_server_info()
        print("Connected to MySQL Server version ", db_Info)
        cursor = connection.cursor()
        cursor.execute("select database();")
        record = cursor.fetchone()
        print("You're connected to database: ", record)

except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL connection is closed")



























# PROXY = "188.132.222.22:8080"
# chrome_options = webdriver.ChromeOptions()
# chrome_options.add_argument('--proxy-server=%s' % PROXY)
# chrome = webdriver.Chrome(chrome_options=chrome_options)
# chrome.get("https://whoer.net/fr")
# sleep(30)


