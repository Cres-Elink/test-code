const ami = require('asterisk-ami-client');
const sugarcrm = require('asterisk-sugarcrm-connector');

// Configure the Asterisk AMI client
const amiClient = new ami({
  reconnect: true,
  keepAlive: true,
  emitEventsByTypes: true,
  silent: true,
});

// Configure the SugarCRM connector
const sugarcrmClient = new sugarcrm({
  host: 'localhost',
  user: 'cres',
  pass: 'qwe123123',
  database: 'orioncrm',
});

// Connect to Asterisk AMI
amiClient.connect('kresmanager', 'grasya', true);

// Connect to SugarCRM database
sugarcrmClient.connect((err) => {
  if (err) {
    console.error('Error connecting to SugarCRM database:', err);
  } else {
    console.log('Connected to SugarCRM database');
  }
});

// Handle incoming call events
amiClient.on('event', (event) => {
  if (event.event === 'Newstate' && event.channelstate === '5') {
    // Parse call information
    const callerId = event.calleridnum;
    const phoneNumber = event.exten;
    const callTime = new Date(event.eventtime * 1000);
    const direction = 'Inbound';

    // Insert call record into SugarCRM database
    const callRecord = {
      direction,
      name: callerId,
      phone_mobile: phoneNumber,
      date_start: callTime,
      duration_hours: 0,
      duration_minutes: 0,
      duration_seconds: 0,
    };
    sugarcrmClient.insertRecord('Calls', callRecord, (err, result) => {
      if (err) {
        console.error('Error inserting new call record:', err);
      } else {
        console.log('New call record inserted:', result);
      }
    });
  }
});
