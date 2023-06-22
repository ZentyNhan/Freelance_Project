########## SECTION: Library ##########
import sys
import os
from contextlib import nullcontext
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
import xlsxwriter
from io import BytesIO


#Lib:
import login.static.lib as lib

#DJANGO:
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.contrib import messages
from django.shortcuts import render, redirect
from django.http import HttpResponse
from login.models import MainDB


########## ANCHOR: DATA ##########
ResponseCode = {
    '200' :	{'status':'Thành công'  ,'detail':'Tham gia Spotify Family thành công'},
    '400' :	{'status':'Thất bại'    ,'detail':'Tham gia Spotify Family thất bại'},
    '401' :	{'status':'Thất bại'    ,'detail':'Đăng nhập không thành công'},
    '402' :	{'status':'Thất bại'    ,'detail':'Chuyển quốc gia không thành công'},
    '403' :	{'status':'Thất bại'    ,'detail':'Liên kết tham gia đã hết hạn'},
    '404' :	{'status':'Thất bại'    ,'detail':'Tham gia Spotify Family thất bại'},
    '405' :	{'status':'Thất bại'    ,'detail':'Tham gia Premium Family từ một quốc gia khác'},
    '406' :	{'status':'Thất bại'    ,'detail':'Tài khoản hoặc mật khẩu không chính xác'},
    '408' : {'status':'Thất bại'    ,'detail':'Request Timeout'},
    '409' :	{'status':'Thất bại'    ,'detail':'Thất bại, không thể thực hiện được'}
}
ResponseProg = {
    
}
########## ANCHOR: METHODS ##########
def ret_dict_met(stt_, detl_):
    return {"status": stt_, "detail": detl_,"time" : datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")}

def DB_Input(id_,User_,PassW_,FamLink_,Addr_,isJoin_,Detail_):
    UserInfo = MainDB(id_, User_, PassW_, FamLink_, Addr_, isJoin_, Detail_)
    UserInfo.save()
    
########## ANCHOR: VIEWS ##########
# Create your views here.

### PAGES ###
def AdminSpotify(request):
    if request.method == 'POST':
        AD_UserN = request.POST.get('uname')
        AD_PassW = request.POST.get('psw')
        AD_User = authenticate(username=AD_UserN, password=AD_PassW)
        if AD_UserN in ""  or AD_PassW in "" :
            ret_dict = ret_dict_met('Error: ', 'username or password can not be blank')
            return render(request, 'Spotify_admin.html', ret_dict)
        elif AD_User is not None:
            login(request, AD_User)
            return redirect('ControlPanel')
        else:
            ret_dict = ret_dict_met('Error: ', 'incorrect username or password. Please try again!')
            return render(request, 'Spotify_admin.html', ret_dict)
    else:
        return render(request, 'Spotify_admin.html')

def joinSpotify(request):
    if request.method == 'POST':
        #Get info from customer:
        UserN = request.POST.get('Uname')
        PassW = request.POST.get('Pwd')
        
        #Process:
        if UserN in ""  or PassW in "" :
            ret_dict = ret_dict_met("Lỗi" , "Tài khoản và mật khẩu không được để trống")
            return render(request, 'Spotify_login.html',ret_dict)
        else:
            try: 
                ########## ANCHOR: DO NOT CHANGE ##########
                # #Get information from PHP:
                Username    = UserN
                Password    = PassW
                familyURL   = 'https://www.spotify.com/vn-vi/family/join/invite/x69cx223A8cbcbY/'
                Address     = 'Binbirdirek, Peykhane Cd. 10/A, 34122 Fatih/İstanbul, Türkiye'
                Nation      = 'VN'
                
                #String Handling:
                dt_format  = "%d-%m-%Y_%H:%M:%S"
                ls         = familyURL.split('/')
                Ind        = ls.index('invite') + 1
                Premium_ID = ls[Ind]
                length     = len(MainDB.objects.all().values()) 
                id         = length + 1 #Calculate ID from current length Users in DB
                
                #Instances:
                ops = webdriver.ChromeOptions()
                ops.add_argument('headless')
                DRIVER         = webdriver.Chrome(ChromeDriverManager().install(), options=ops)
                LOGGING        = lib.logging(os.getcwd())
                USER           = lib.Process(Username, Password, familyURL, Address, Nation, LOGGING)
                code           = '400'
                failure        = ['Failure', 'Timeout']
                Debug_1        = 'none'
                Debug_2        = 'none'
                Status         = 'none'

                #Method:
                Debug_1 = USER.accessSpotify(DRIVER)
                if Debug_1 in 'Valid':
                    Debug_2 = USER.switchNation(DRIVER)
                    if Debug_2 in 'Success':
                        Status  = USER.joinPremium(DRIVER)
                        if Status in 'Success':
                            code     = '200'
                        elif Status in 'Join Link expired':
                            code     = '403'
                        else: 
                            code     = '400'
                    elif Debug_2 in 'Join Link expired':
                        code     = '403'
                    elif Debug_2 in 'Wrong nation address':
                        code     = '405'
                    else:
                        code     = '402'
                elif Debug_1 in 'Invalid':
                    code     = '406'
                else:
                    code     = '401'
                #Close driver:
                DRIVER.close()
                
                #Check ret
                if Debug_1[:7] in failure[1] or \
                    Debug_2[:7] in failure[1] or \
                    Status[:7] in failure[1]:
                    code = '408'
                    ret_dict = ret_dict_met(ResponseCode[code]['status'], ResponseCode[code]['detail'])
                else:
                    ret_dict = ret_dict_met(ResponseCode[code]['status'], ResponseCode[code]['detail'])
                
                #Update on DB:
                if code == '200': DB_Input(id, Username, Password, familyURL, Address, True, ResponseCode[code]['detail'])
                else:             DB_Input(id, Username, Password, familyURL, Address, False, ResponseCode[code]['detail'])
                
            ### Exception ###
            #Timeout:
            except TimeoutException as error:
                code = '408'
                ret_dict = ret_dict_met(ResponseCode[code]['status'], ResponseCode[code]['detail'])
                DB_Input(id, Username, Password, familyURL, Address, False, ResponseCode[code]['detail'])
            #Others:
            except:
                code = '409'
                ret_dict = ret_dict_met(ResponseCode[code]['status'], ResponseCode[code]['detail'])
                DB_Input(id, Username, Password, familyURL, Address, False, ResponseCode[code]['detail'])
                
            #Return: 
            return render(request, 'Spotify_login.html',ret_dict)
    else:
        #Return: 
        return render(request, 'Spotify_login.html')
    
### EVENTS ###
@login_required(login_url='/Spot-admin')
def ExportReport(request):   
    length  = len(MainDB.objects.all().values())
    DB_data = MainDB.objects.all().values()
    
    ### Excel handling ###
    output = BytesIO()
    workbook = xlsxwriter.Workbook(output)
    worksheet = workbook.add_worksheet('Report')
    #Header:
    header_data = ['ID', 'Email/PhoneNumber', 'Famimy link', 'Address', 'Joined Family', 'Detail']
    header_format = workbook.add_format({'bold': True,'bottom': 2,'bg_color': '#F9DA04'})
    for col_num, data in enumerate(header_data):
        worksheet.write(0, col_num, data, header_format)
    #Data in excel:
    for row in range(1,length+1):
        for column in range(len(header_data)):
            if column == 0:   worksheet.write(row, column, DB_data[row-1]['id'])
            elif column == 1: worksheet.write(row, column, DB_data[row-1]['Username'])
            elif column == 2: worksheet.write(row, column, DB_data[row-1]['FamLink'])
            elif column == 3: worksheet.write(row, column, DB_data[row-1]['Address'])
            elif column == 4: worksheet.write(row, column, DB_data[row-1]['isJoined'])
            elif column == 5: worksheet.write(row, column, DB_data[row-1]['Detail'])
            else:
                #For next release
                pass
    workbook.close()

    ### Reponse handling ###
    # create a response
    response = HttpResponse(content_type='application/vnd.ms-excel')
    # tell the browser what the file is named
    response['Content-Disposition'] = f'attachment;filename="SAReport_{datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")}.xlsx"'
    # put the spreadsheet data into the response
    response.write(output.getvalue())
    # return the response
    return response

def LogoutAdmin(request):   
    logout(request)
    return redirect('Administrator')

### OTHERS ###
def get_test(request):
    return render(request, 'test.html')

def get_test_rep(request):
    return HttpResponse('')

def get_login(request):
    return render(request, 'Spotify_login.html')

def SysCtrlSpotify(request):
    return render(request, 'Spotify_control.html')