########## SECTION: Library ##########
import sys
from pickle import FALSE, TRUE
from subprocess import check_output
# from webdriver_manager.chrome import ChromeDriverManager #Window flatform only
# from pyvirtualdisplay import Display  #Window flatform only
from selenium import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.select import Select
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import NoSuchElementException,ElementNotInteractableException,ElementClickInterceptedException
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from datetime import datetime
from datetime import date
import time
import pickle
import datetime
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import json
#Self lib
import lib_demo

if __name__ == "__main__": 
    
    ########## ANCHOR: DO NOT CHANGE ##########
    #Get information from PHP:
    Email       = 'freetest9323@kikyushop.com'
    PassW       = 'Hoang123'
    familyURL   = 'https://www.spotify.com/vn-vi/family/join/invite/2X06z34zc93zB11/'
    Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'

    #String Handling:
    dt_format  = "%d-%m-%Y_%H:%M:%S"
    ls         = familyURL.split('/')
    Ind        = ls.index('invite') + 1
    Premium_ID = ls[Ind]

    #Instances:
    driver_location = '/usr/bin/chromedriver'
    # binary_location = '/usr/bin/google-chrome'
    options = webdriver.ChromeOptions()
    # options.binary_location = binary_location
    options.add_argument('--no-sandbox')
    options.add_argument('--window-size=1420,1080')
    options.add_argument("user-data-dir=selenium")
    options.add_argument('--headless')
    options.add_argument('--disable-gpu')
    DRIVER = webdriver.Chrome(executable_path=driver_location,options=options)
    USER   = lib_demo.Process(Email, PassW, familyURL, Address)

    Debug_1 = USER.accessSpotify(DRIVER)
    print(Debug_1)
