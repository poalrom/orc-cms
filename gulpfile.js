const requireDir = require('require-dir'),
    tasks = requireDir('./gulp_tasks');

for (let task in tasks){
    if (!tasks.hasOwnProperty(task)){
        continue;
    }
    if (typeof tasks[task] === 'function'){
        tasks[task]();
    }
}