from django.contrib import admin
from django.urls import path
from . import views as login

urlpatterns = [
    path('Spotify-join/', login.joinSpotify),
    path('resp', login.get_test_rep),
    path('', login.get_login), #default
    #TEST:
    path('test/', login.get_test),
    
]