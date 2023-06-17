########## SECTION: Library ##########
import sys
import os
from pickle import FALSE, TRUE
from subprocess import check_output
from webdriver_manager.chrome import ChromeDriverManager #Window flatform only
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

#Lib:
import login.static.lib as lib

#DJANGO:
from django.shortcuts import render
from django.http import HttpResponse

# Create your views here.
def get_login(request):
    return render(request, 'login.html')

def joinSpotify(request):
    if request.method == 'POST':
        UserN = request.POST.get('username')
        PassW = str(request.POST.get('password'))
        
        #Instances:
        # op = webdriver.ChromeOptions()
        # op.add_argument('headless')
        chrome_options = Options()
        chrome_options.add_argument("--headless=new")
        DRIVER         = webdriver.Chrome(ChromeDriverManager().install(), options=chrome_options)
        LOGGING        = lib.logging(os.getcwd())
        USER           = lib.Process(UserN, PassW, 'dummy_1', 'dummy_2', 'dummy_3', LOGGING)
        code           = '400'
        failure        = ['Failure', 'Timeout']
        failureMessage = 'none'

        #Method:
        # Method:
        Debug_1 = USER.accessSpotify(DRIVER)
        if Debug_1 == "Valid":
            code  = '200'
            message  = 'Tài khoản hợp lệ'
        else:
            message  = 'Tài khoản hoặc mật khẩu không hợp lệ'
        DRIVER.close()
            
        if Debug_1 == 'Invalid':
            ret_dict = {
                'status'     : code,
                'failure'    : failureMessage,
            }
        elif Debug_1[:7] not in failure:
            ret_dict = {
                'status'     : code,
                'username'   : UserN,
            }
        elif Debug_1[:7] in failure[1]:
            ret_dict = {
                'status'     : '408',
                'failure'    : failure[1],
            } 
        else:
            ret_dict = {
                'status'     : code,
                'failure'    : failureMessage,
            }

        #Return:
        print(json.dumps(ret_dict))
        return render(request, 'login.html')
    else:
        return render(request, 'login.html')

def get_test(request):
    return render(request, 'test.html')

def get_test_rep(request):
    return HttpResponse()