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

echo "Do GAS ..."
./dogas/dogas.R
./dofitbit/dofitbit.R

cd ~/websites/nudge
git add . --all
git commit -am "dolifecoach batch script"
git push
