const ami = require('asterisk-ami');


const amiConfig = {
  username: 'cresmanager',
  password: 'grasya',
  host: '192.168.2.178',
  port: 5038,
};



const amiClient = new ami(amiConfig);


amiClient.on('connect', () => {
  console.log('Connected to Asterisk AMI');
});

amiClient.on('event', (event) => {
  if (event.event === 'Newstate' && event.channelstate === '5') {
    const call = {
      direction: 'Inbound',
      name: event.calleridnum,
      phone_mobile: event.exten,
      date_start: new Date().toISOString(),
      duration_hours: 0,
      duration_minutes: 0,
      duration_seconds: 0,
    };
    console.log('call');
  }
});

amiClient.connect();

