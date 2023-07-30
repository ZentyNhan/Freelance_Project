from django.contrib import admin
from django.urls import path
from . import views as API

urlpatterns = [
    path('', API.get_login), #default
    path('Spot-join/',                              API.joinSpotify, name='joinSpotify'),
    path('Spot-admin/',                             API.AdminSpotify, name='Administrator'),
    #TAB:        
    path('Spot-SysCtrl/joinLink',                   API.SysCtrlSpotifyTab, name='ControlPanel'),
    path('Spot-SysCtrl/verification',               API.VerificationTab, name='VerificationTab'),
    path('Spot-SysCtrl/ProxyManage',                API.ProxyManageTab, name='ProxyManageTab'),
    path('Spot-SysCtrl/joinLink/exportReport',      API.ExportReport, name='ExportReport'),
    path('Spot-SysCtrl/verification/GenerateCode',  API.GenerateCode, name='GenerateCode'),
    path('Spot-SysCtrl/UpdateCode',                 API.UpdateCode, name='UpdateCode'),
    path('Spot-SysCtrl/joinLink/uploadData',        API.UploadData, name='UploadData'),
    path('Spot-SysCtrl/joinLink/uploadProxy',       API.UploadProxy, name='UploadProxy'),
    path('Spot-SysCtrl/joinLink/addProxy',          API.AddProxy, name='AddProxy'),
    path('Spot-SysCtrl/joinLink/editData',          API.EditData, name='EditData'),
    path('Spot-SysCtrl/joinLink/editProxy',         API.EditProxy, name='EditProxy'),
    path('LogoutAdmin',                             API.LogoutAdmin, name='LogoutAdmin'),
    #EVENT FETCH:        
    path('verification/delete',                     API.DeleteCode),
    path('joinLink/delete',                         API.DeleteAccount),
    path('Spot-SysCtrl/changeNation',               API.ChangeNation),
    #TEST:        
    path('resp',                                    API.get_test_rep),
    path('test/',                                   API.get_test),
    
]