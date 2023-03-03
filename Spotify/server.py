########## SECTION: Library ##########
from ast import Try, keyword
from contextlib import nullcontext
from lib2to3.pgen2.literals import test
import os
import time
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
import json

from http.server import BaseHTTPRequestHandler
import os
import spotify

class Server(BaseHTTPRequestHandler):
    def do_GET(self):
        # #Process:
        # #Local var
        # Email       = ['z.ntnhan19@gmail.com']
        # PassW       = ['Nhan0334842024']
        # familyURL   = 'https://www.spotify.com/vn-vi/family/join/invite/C3Cx803CX968Ya1/'
        # Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'
        # ret_dict    = {}

        # ########## ANCHOR: DO NOT CHANGE ##########
        # #Instance:
        # DRIVER = webdriver.Chrome('chromedriver.exe')
        # USER   = spotify.Process(Email[0], PassW[0], familyURL, Address)

        # #Method:
        # USER.accessSpotify(DRIVER)
        # USER.SUPER_DELAY
        # USER.switchNation(DRIVER)
        # USER.HARD_DELAY

        # # Send request to Database:
        # Status, Username, ID_Premium = USER.joinPremium(DRIVER)
        # ret_dict['JSON'] = dict(ret_dict)
        # ret_dict['JSON'] = {
        #     'Status'     : Status,
        #     'Username'   : Username,
        #     'ID_Premium' : ID_Premium
        # }

        #put on index:
        var_a = {'user' : 'NguyenThanhNhan', 'passw' : '123456', 'Premium_ID' : 'HCM'}
        self.path = 'index.html'
        try:
            f = open(self.path).readlines()
            f[3] = '{0}\n'.format(var_a)
            open(self.path, 'w').writelines(f)
            split_path = os.path.splitext(self.path)
            request_extension = split_path[1]
            if request_extension != ".py":
                f = open(self.path).read()
                self.send_response(200)
                self.end_headers()
                self.wfile.write(bytes(f, 'utf-8'))
            else:
                f = "File not found"
                self.send_error(404,f)
        except:
            f = "File not found"
            self.send_error(404,f)
        
    def do_POST(self):
        pass
    
    def send_error(self):
        pass

