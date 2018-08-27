var firebaseConfig = {
	apiKey: "AIzaSyAiQMoJiDNgbTGcHeF7gG2Dg7oDpJyKv1E",
	authDomain: "place2pay-f42a8.firebaseapp.com",
	databaseURL: "https://place2pay-f42a8.firebaseio.com",
	projectId: "place2pay-f42a8",
	storageBucket: "place2pay-f42a8.appspot.com",
	messagingSenderId: "73784397899"
};

window.onload(function(){
	var app = firebase.initializeApp(firebaseConfig);
	var database = firebase.database();

	firebase.database().ref('transaction').once('value').then(
		function(snapshot)
		{
			console.log(snapshot.val().username)
		}
	);
});