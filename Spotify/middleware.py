#Web server:
from http.server import HTTPServer
from server import Server
import time

#HOST and PORT:
HOST_NAME = 'python.bizonc.com'
PORT = 80

#SERVER:
httpd = HTTPServer((HOST_NAME,PORT), Server)
print(time.asctime(), "Start Server - %s:%s"%(HOST_NAME,PORT))
try:
    httpd.serve_forever()
except KeyboardInterrupt:
    print('interrupted!')
httpd.server_close()
print(time.asctime(),'Stop Server - %s:%s' %(HOST_NAME,PORT))