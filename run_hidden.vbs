Set oShell = CreateObject("WScript.Shell")
oShell.Run "cmd /C """ & WScript.Arguments(0) & """ """ & WScript.Arguments(1) & """ """ & WScript.Arguments(2) & """ """ & WScript.Arguments(3) & """ """ & WScript.Arguments(4) & """", 0, False
WScript.Quit
