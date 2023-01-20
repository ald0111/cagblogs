#!/usr/bin/python

print "Content-type:text/html\r\n\r\n"
print '<html>'
print '<head>'
print '<title>Hello World - First CGI Program</title>'
print '</head>'
print '<body>'
print '<h2>Hello World! This is my first CGI program</h2>'

import cgitb
cgitb.enable(display=0, logdir="/cagblogs.atspace.eu/log/")

import socket
print '<p>1</p>'
sock = socket.socket()
print '<p>2</p>'
sock.bind(('',4444))
print '<p>3</p>'
sock.listen(5)
print '<p>4</p>'
while True:
        print '<p>5</p>'
        c, addr = sock.accept()
        print '<p>6</p>'
        print c
        print '<p>7</p>'
        print addr
        print '<p>8</p>'
        sock.send(bytes("Connected Successfully","utf-8"))
        print '<p>9</p>'
        sock.close()
        print '<p>10</p>'
print '<p>11</p>'
print '</body>'
print '</html>'