//suite crm click 2 dial inbound notification testing
const ami = require('asterisk-manager')('192.168.2.178','5038', 'cresmanager', 'grasya', true);

ami.on('managerevent', (evt) => {
  if (evt.event === 'Newstate' && evt.channelstate === '5') { // check for incoming call state
    const callerid = evt.calleridnum;
    const calltime = evt.timestamp;
    // insert new record into SuiteCRM database using SQL query
    // Configure the MySQL connection to the SuiteCRM database
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'orioncrm',
  });
  
  // Connect to the MySQL database
  connection.connect((error) => {
    if (error) {
      console.error('Error connecting to the SuiteCRM database:', error);
    } else {
      console.log('Connected to the SuiteCRM database');
    }
  });
    // Example: db.query(`INSERT INTO calls (callerid, calltime) VALUES ('${callerid}', '${calltime}')`, (err, result) => { ... });
  }
});

ami.keepConnected();
