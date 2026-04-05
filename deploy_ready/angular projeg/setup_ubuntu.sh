#!/bin/bash

# COLORS
GREEN='\033[0;32m'
CYAN='\033[0;36m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# TYPING EFFECT FUNCTION
type_effect() {
    text="$1"
    delay=0.03
    for (( i=0; i<${#text}; i++ )); do
        echo -n "${text:$i:1}"
        sleep $delay
    done
    echo ""
}

# CLEAR SCREEN
clear

echo -e "${GREEN}"
echo "#########################################################"
echo "#                                                       #"
echo "#        SYSTEM INITIALIZATION: ANGULAR V13.3           #"
echo "#        AUTHORIZED ACCESS ONLY                         #"
echo "#                                                       #"
echo "#########################################################"
echo -e "${NC}"

type_effect "${CYAN}[INFO] Initiating system update...${NC}"
sudo apt update -y > /dev/null 2>&1

type_effect "${CYAN}[INFO] Fetching NVM (Node Version Manager)...${NC}"
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh 2>/dev/null | bash > /dev/null 2>&1

# Loading NVM
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

type_effect "${CYAN}[INFO] Injecting Node.js v16 environment...${NC}"
nvm install 16 > /dev/null 2>&1
nvm use 16 > /dev/null 2>&1

type_effect "${CYAN}[INFO] Deploying Angular CLI @13.3.11 globally...${NC}"
npm install -g @angular/cli@13.3.11 > /dev/null 2>&1

type_effect "${CYAN}[INFO] Compiling local dependencies...${NC}"
npm install > /dev/null 2>&1

echo -e "\n${GREEN}>>> SYSTEM READY. LAUNCHING KERNEL... <<<${NC}\n"
sleep 1

# Start the application
type_effect "${GREEN}[SUCCESS] Running: npm start${NC}"
npm start
