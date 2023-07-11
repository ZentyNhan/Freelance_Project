########## SECTION: Library ##########
import sys
import os
from contextlib import nullcontext
from pickle import FALSE, TRUE
from subprocess import check_output
from webdriver_manager.chrome import ChromeDriverManager #Window flatform only
from seleniumwire import webdriver
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
# from selenium import webdriver
# from selenium.webdriver.chrome.options import Options
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
from login.models import MainDB, MasterAccountDB
from tablib import Dataset

########## ANCHOR: GLOBAL ATTIRIBUTES ##########

ret_dict = {}
DT_format = "%d/%m/%Y %H:%M:%S"
D_format  = "%d/%m/%Y"
DTRes_format  = "%H:%M:%S - %d/%m/%Y "

########## ANCHOR: GLOBAL METHODS ##########
def ret_dict_met(stt_, detl_):
    return {"status": stt_, "detail": detl_,"time" : datetime.datetime.now().strftime(DT_format)}

def DB_Input(id_,User_,  PassW_, MasterAcc_, FamLink_, Addr_, isJoin_, Detail_):
    UserInfo = MainDB(id_, User_, PassW_, MasterAcc_, FamLink_, Addr_, isJoin_, Detail_,datetime.datetime.now().strftime(DT_format))
    UserInfo.save()
    
def DB_upload(id_,User_,PassW_,FamLink_,Addr_,Nation_,Memnum_, Remark_, Date_):
    if Date_ in [None, 'None', '']:    
        Date_ = datetime.datetime.now().strftime(DT_format)
    MasterUserInfo = MasterAccountDB(id_, User_, PassW_, FamLink_, Addr_, Nation_, Memnum_ , Date_)
    MasterUserInfo.save()
    
def DB_get_master_info():
    master_info_list  = list(MasterAccountDB.objects.all().values())
    if master_info_list != []:
        for master_info in master_info_list:
            if master_info['MemNum'] != 0:
                id_        = master_info['id']
                MasterAcc_ = master_info['Username']
                familyURL_ = master_info['FamLink']
                Address_   = master_info['Address']
                NemNum_    = master_info['MemNum']
                Nation_    = master_info['Nation']
                return [id_,MasterAcc_,familyURL_,Address_,NemNum_,Nation_]
    else:
        return 'Database is null'
    return 'No available slot'
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
                ### Check information from DB:
                # id handling:
                length       = len(MainDB.objects.all().values()) 
                id           = length + 1 #Calculate ID from current length Users in DB
                # get master information:
                Master_infor = DB_get_master_info()
                if  Master_infor in ['Database is null']:
                    code = '411'
                    ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    DB_Input(id, UserN, PassW, 'null', 'null', 'null', False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                elif  Master_infor in ['No available slot']:
                    code = '412'
                    ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    DB_Input(id, UserN, PassW, 'null', 'null', 'null', False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                else:
                    # Customer information:
                    Username    = UserN
                    Password    = PassW
                    Master_id   = Master_infor[0]
                    MasterAcc   = Master_infor[1]
                    familyURL   = Master_infor[2]
                    Address     = Master_infor[3]
                    MemNum      = Master_infor[4] #Current member number.
                    Nation      = Master_infor[5]
                    
                    print('Master_id: ',Master_id)
                    #String Handling:
                    dt_format  = "%d-%m-%Y_%H:%M:%S"
                    ls         = familyURL.split('/')
                    Ind        = ls.index('invite') + 1
                    Premium_ID = ls[Ind]
                    
                    #Instances:
                    #Options:
                    ops = webdriver.ChromeOptions()
                    # ops.add_argument('headless')
                    options = {
                        'proxy': {
                            'http':  '{0}://{1}:{2}@{3}'.format(lib.proxy.info[2]['protocol'], lib.proxy.info[2]['User'], lib.proxy.info[2]['PW'], lib.proxy.info[2]['IP']),
                            'https': '{0}://{1}:{2}@{3}'.format(lib.proxy.info[2]['protocol'], lib.proxy.info[2]['User'], lib.proxy.info[2]['PW'], lib.proxy.info[2]['IP']),
                            'no_proxy': 'localhost,127.0.0.1'
                        }
                    }
                    
                    DRIVER         = webdriver.Chrome(ChromeDriverManager().install(),options= ops, seleniumwire_options=options)
                    LOGGING        = lib.logging(Username, familyURL, MasterAcc, Nation, os.getcwd())
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
                            elif Status in 'Wrong nation address':
                                code     = '410'
                            elif Status in 'Join Link expired':
                                code     = '403'
                            elif Status in 'Join Link error':
                                code     = '405'
                            else: 
                                code     = '400'
                        elif Debug_2 in 'Join Link expired':
                            code     = '403'
                        else:
                            code     = '402'
                    elif Debug_1 in 'Invalid':
                        code     = '406'
                    else:
                        code     = '401'
                    #Close driver:
                    DRIVER.close()
                    
                    ########## ANCHOR: REPORT AND DB HANDLING ##########
                    ##### "SUCCESS" TEST: #####
                    # code = '200'
                    ###########################
                    
                    ### Check error ret: ###
                    if Debug_1[:7] in failure[1] or \
                        Debug_2[:7] in failure[1] or \
                        Status[:7] in failure[1]:
                        code = '408'
                        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    else:
                        ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                    
                    ### Update on DB: ###
                    if code == '200': 
                        DB_Input(id, Username, Password, MasterAcc, familyURL, Address, True, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                        #Update member number:
                        UpdateDB = MasterAccountDB.objects.get(id=Master_id)
                        UpdateDB.MemNum = int(MemNum) - 1
                        UpdateDB.save()
                    else:             
                        DB_Input(id, Username, Password, MasterAcc, familyURL, Address, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                
            ########## ANCHOR: EXCEPTIONS ##########
            #Timeout:
            except TimeoutException as error:
                code = '408'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                DB_Input(id, Username, Password, MasterAcc, familyURL, Address, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
            # Others:
            except:
                code = '409'
                ret_dict = ret_dict_met(lib.ResConfig.ResponseCode[code]['status'], lib.ResConfig.ResponseCode[code]['detail']['customer'])
                DB_Input(id, Username, Password, MasterAcc, familyURL, Address, False, lib.ResConfig.ResponseCode[code]['detail']['admin'])
                
            #Return: 
            return render(request, 'Spotify_login.html',ret_dict)
    else:
        #Return: 
        return render(request, 'Spotify_login.html')
    
### EVENTS ###
########## ANCHOR: ExportReport ##########
@login_required(login_url='/Spot-admin')
def ExportReport(request):   
    if request.method == 'POST':
        ### Input ###
        Sel_month  = request.POST.get('monthfilter_n')
        DB_rawdata = MainDB.objects.all().values()
        fil_data   = []
        ### Raw data handling ###
        for raw in DB_rawdata:
            if str(raw['Datetime'][3:5]) == str(Sel_month):
                fil_data.append(raw)
        #length/data:  
        if Sel_month == 'All':  
            length = len(DB_rawdata)
            data   = DB_rawdata
        else:                   
            length = len(fil_data) 
            data   = fil_data
            
        ### Excel handling ###
        output = BytesIO()
        workbook = xlsxwriter.Workbook(output)
        worksheet = workbook.add_worksheet('Report')
        #Tittle:
        tittle_format = workbook.add_format({
            'bold':     True,
            'border':   6,
            'font_size':   20,
            'align':    'center',
            'valign':   'vcenter',
            'fg_color': '#D7E4BC',
        })
        worksheet.merge_range('A1:H2', 'Spotify Family Report', tittle_format)
        #Header:
        header_data = ['ID', 'Email/PhoneNumber', 'Master Account', 'Famimy link', 'Address', 'Joined Family', 'Detail', 'Date']
        header_format = workbook.add_format({'bold': True,'border': 1, 'align': 'center','bg_color': '#5BC85B'})
        for col_num, x_data in enumerate(header_data):
            worksheet.write(2, col_num, x_data, header_format)
        #Data in excel:
        if data == []:
            error_format = workbook.add_format({'bold': True, 
                                                'border': 1, 
                                                'font_color': 'red', 
                                                'text_wrap': True,
                                                'align':'center',
                                                'valign': 'vcenter', 
                                                'fg_color': '#FFFF00',})
            worksheet.merge_range('A4:H7', 'Empty data. Please check again!\n(Maybe there is no user joined in this month) ', error_format)
        else:
            data_format = workbook.add_format({'border': 1, 'align':'center'})
            for row in range(3,length+3):
                for column in range(len(header_data)):
                    if column == 0:   worksheet.write(row, column, data[row-3]['id']                                    , data_format)
                    elif column == 1: worksheet.write(row, column, data[row-3]['Username']                              , data_format)
                    elif column == 2: worksheet.write(row, column, data[row-3]['MasterAccout']                          , data_format)
                    elif column == 3: worksheet.write(row, column, data[row-3]['FamLink']                               , data_format)
                    elif column == 4: worksheet.write(row, column, data[row-3]['Address']                               , data_format)
                    elif column == 5: worksheet.write(row, column, 'Yes' if data[row-3]['isJoined'] == True else 'No'   , data_format)
                    elif column == 6: worksheet.write(row, column, data[row-3]['Detail']                                , data_format)
                    elif column == 7: worksheet.write(row, column, data[row-3]['Datetime']                              , data_format)
                    else:
                        #For next release
                        pass
        worksheet.autofit()
        workbook.close()

        ### Reponse handling ###
        # create a response
        response = HttpResponse(content_type='application/vnd.ms-excel')
        # tell the browser what the file is named
        response['Content-Disposition'] = f'attachment;filename="SFReport_{datetime.datetime.now().strftime(DT_format)}.xlsx"'
        # put the spreadsheet data into the response
        response.write(output.getvalue())
        # return the response
        return response

@login_required(login_url='/Spot-admin')
########## ANCHOR: UploadData ##########
def UploadData(request):   
    if request.method == 'POST':
        try: 
            ### Input ###
            dataset = Dataset()
            data    = []
            
            #Import excel:
            excel_file = request.FILES['uploadData-name']
            import_data = dataset.load(excel_file.read(), format='xlsx')
            # Change "Dataset" to "List"
            for data_col in import_data:
                if data_col[6] not in [None, 'None', 'Date']:
                    data.append({'Username' : data_col[0], 
                                'Password' : data_col[1], 
                                'FamLink'  : data_col[2], 
                                'Address'  : data_col[3], 
                                'Nation'   : data_col[4], 
                                'MemNum'   : data_col[5], 
                                'Date'     : (data_col[6]).strftime(D_format),
                                'Remark'   : data_col[7]})
            #Update on DB:
            for Master_acc in data:
                length  = len(MasterAccountDB.objects.all().values())
                id      = length + 1
                if Master_acc['Username'] not in ['Master Username', None]:
                    DB_upload(id,
                            Master_acc['Username'],  
                            Master_acc['Password'],
                            Master_acc['FamLink'],
                            Master_acc['Address'],
                            lib.ResConfig.langcode[Master_acc['Nation']],
                            Master_acc['MemNum'],
                            'Nothing to note',
                            Master_acc['Date'])

            #Return:
            ret_dict = {'status' : 'Upload successfully' , 'datetime' : f'{datetime.datetime.now().strftime(DT_format)}'}
            return render(request, 'Spotify_control.html',ret_dict)
        except Exception as error:
            ret_dict = {'status' : f'Upload failed' , 'reason' : error , 'datetime' : f'{datetime.datetime.now().strftime(DT_format)}'}
            return render(request, 'Spotify_control.html',ret_dict)
    else:
        ret_dict = {'status' : '' , 'datetime': ''}
        return render(request, 'Spotify_control.html',ret_dict)

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