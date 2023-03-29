const mysql = require('mysql');
const ami = require('asterisk-ami');
const AsteriskConnector = require('asterisk-ami-connector');

// Configure the Asterisk AMI client
const amiClient = new ami('cresmanager', 'grasya', '192.168.2.178', 5038);

// Configure the MySQL connection to the SuiteCRM database
const connection = mysql.createConnection({
  host: '127.0.0.1',
  user: 'cres',
  password: 'qwe123!@#',
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

// Configure the Asterisk connector
const connector = new AsteriskConnector({
  amiUsername: 'user',
  amiPassword: 'password',
  amiHost: 'localhost',
  amiPort: 5038,
  events: ['Newstate', 'Newchannel', 'Hangup'],
});

// Start listening to Asterisk events
connector.on('event', (event) => {
  if (event.Event === 'Newstate' && event.ChannelState === '5') {
    // Handle incoming call
    const callerId = event.CallerIDNum;
    const phoneNumber = event.Exten;
    const callTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const direction = 'Inbound';

    // Insert a new record into the Calls module
    const callQuery = `INSERT INTO calls (direction, name, phone_mobile, date_start, duration_hours, duration_minutes, duration_seconds) VALUES ('${direction}', '${callerId}', '${phoneNumber}', '${callTime}', 0, 0, 0)`;
    connection.query(callQuery, (error, results, fields) => {
      if (error) {
        console.error('Error inserting new call record:', error);
      } else {
        console.log('New call record inserted:', results);
      }
    });

    // Check if the contact already exists in the Contacts module
    const contactQuery = `SELECT id FROM contacts WHERE phone_mobile = '${phoneNumber}'`;
    connection.query(contactQuery, (error, results, fields) => {
      if (error) {
        console.error('Error searching for contact:', error);
      } else if (results.length > 0) {
        console.log('Contact found:', results[0].id);
      } else {
        // Insert a new record into the Contacts module
        const contactName = callerId;
        const contactQuery = `INSERT INTO contacts (salutation, first_name, last_name, phone_mobile) VALUES ('', '${contactName}', '', '${phoneNumber}')`;
        connection.query(contactQuery, (error, results, fields) => {
          if (error) {
            console.error('Error inserting new contact record:', error);
          } else {
            console.log('New contact record inserted:', results);
          }
        });
      }
    });
  }
});

// Connect to Asterisk AMI
amiClient.connect(() => {
  console.log('Connected to Asterisk AMI');

  // Start the Asterisk connector
  connector.connect(() => {
    console.log('Connected to Asterisk');
  });
});
