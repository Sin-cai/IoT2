const powerSwitch = document.getElementById('powerSwitch');
const unitSwitches = document.querySelectorAll('.unitSwitch');
const logsContainer = document.getElementById('logsContainer');

powerSwitch.addEventListener('change', function() {
  const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  let logMessage = '';

  if (this.checked) {
    logMessage = `Power ON - Activated at ${currentTime}`; // Use backticks and curly braces
  } else {
    logMessage = `Power OFF - Deactivated at ${currentTime}`; // Use backticks and curly braces
  }

  const logEntry = document.createElement('div');
  logEntry.className = 'log-entry';
  logEntry.innerHTML = `<p>${logMessage} <span>- ${currentTime}</span></p>`;
  logsContainer.appendChild(logEntry);
  logsContainer.scrollTop = logsContainer.scrollHeight; // Auto-scroll
});

unitSwitches.forEach(switchElement => {
  switchElement.addEventListener('change', function() {
    const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const unitName = this.dataset.name; // Get the name of the unit

    let logMessage = '';
    if (this.checked) {
      logMessage = `${unitName} ON - Activated at ${currentTime}`; // Use backticks and curly braces
    } else {
      logMessage = `${unitName} OFF - Deactivated at ${currentTime}`; // Use backticks and curly braces
    }

    const logEntry = document.createElement('div');
    logEntry.className = 'log-entry';
    logEntry.innerHTML = `<p>${logMessage} <span>- ${currentTime}</span></p>`;
    logsContainer.appendChild(logEntry);
    logsContainer.scrollTop = logsContainer.scrollHeight; // Auto-scroll
  });
});