#!/bin/sh

# www.openshift.com
# login: spicozzi@redhat.com
# app: nudge
# alias: www.satimetry.com

cp ~/.openshift/redhat-express.conf ~/.openshift/express.conf

echo "Show domain status ..."
rhc domain show -p Dopamine@1

echo "Check nudge client application status ..."
client=`rhc app show --state nudge -p Dopamine@1 | grep started | wc -l`
if [ $client != 1 ]; then
  echo "Application is starting"
  rhc app start nudge -p Dopamine@1
else
  echo "Nudge Client Application is started"
fi

echo "Check nudge server application status ..."
server=`rhc app show --state nudgeserver -p Dopamine@1 | grep started | wc -l`
if [ $server != 1 ]; then
  echo "Application is starting"
  rhc app start nudgeserver -p Dopamine@1
else
  echo "Nudge Server Application is started"
fi

cd ~/websites/nudge/R/lifecoach
echo "Launch database port forwarding ..."
nohup rhc port-forward nudgeserver -p Dopamine@1 > nohup.log 2>&1&
echo $! > pid.txt
sleep 45

echo "Do GAS ..."
./dogas/dogas.R
./dofitbit/dofitbit.R

echo "Stop database port forwarding ..."
kill -9 `cat pid.txt`

cd ~/websites/nudge
git add . --all
git commit -m "X"
git push
