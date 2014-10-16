ids=[];
arr= document.querySelectorAll('ul.cnfList a[usercard]');
for(i=0; i< arr.length;i++){
	ids.push(arr[i].getAttribute('usercard').split('=')[1]);
}
console.log(ids.join(','));