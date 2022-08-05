@echo off & set local

:: -------- Get Admin Priviliges for Installation --------

:: BatchGotAdmin
:-------------------------------------
::  --> Check for permissions
IF "%PROCESSOR_ARCHITECTURE%" EQU "amd64" (
>nul 2>&1 "%SYSTEMROOT%\SysWOW64\cacls.exe" "%SYSTEMROOT%\SysWOW64\config\system"
) ELSE (
>nul 2>&1 "%SYSTEMROOT%\system32\cacls.exe" "%SYSTEMROOT%\system32\config\system"
)

:: --> If error flag set, we do not have admin.
if '%errorlevel%' NEQ '0' (
    echo Requesting administrative privileges...
    goto UACPrompt
) else ( goto gotAdmin )

:UACPrompt
    echo Set UAC = CreateObject^("Shell.Application"^) > "%temp%\getadmin.vbs"
    set params= %*
    echo UAC.ShellExecute "cmd.exe", "/c ""%~s0"" %params:"=""%", "", "runas", 1 >> "%temp%\getadmin.vbs"

    "%temp%\getadmin.vbs"
    del "%temp%\getadmin.vbs"
    exit /B

:gotAdmin
    pushd "%CD%"
    cd "%~dp0"
:--------------------------------------

:: path to git bash executable
set pathBashExecuteable=%programfiles%\Git\bin\sh.exe
:: path to source directory of the program
set pathBashScript=start_xampp_server_helper.sh

echo.
echo.
echo.
echo -------- PHP Server wird gestartet und Programm geoeffnet --------
echo.
echo.
echo Warte einen Moment ...
echo Dieses Fenster nicht schliessen
echo.
echo.
echo.

:: start xampp via bash script
:: cause only with bash the xampp start process ends
:: and the console window can be closed automatically
:: if done with cmd, the console window stays open
"%pathBashExecuteable%" "%pathBashScript%"