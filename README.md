Pukis
=====
Ajax user management dashboard
- Demo : http://pukis.kodehive.com
- Username : superdemo, admindemo, userdemo
- Password : demoo123

CakePHP is choosen for this projects because its provides the main reason of a framework which would help us to launch the project faster.
In the other side, using ajax will faster your application load since it doesn't to transfer the additional resources (css, js, etc) everytime request is performed. Ajax bypasing to check wheter they are exist or not on your web browser cache.

Features :
-  Ajax User Management - Ajax access control list user management
- Json Configuration Management - Configuration setting management for your application in json
- Table Helper - Generate your table with sorting and pagination only by configurations

Plan for Future Version :
- Frontend - Angular.js integration
- Backend - SOA architecture
- Functionality - Emails
- Functionality - Pages and Menu

Installation :
- Copy these source to your document root (/var/www, etc)
- Dump database schema from App/Modules/Pukis/Config/Schema
- Configure your database configuration App/Config/database.php

Sorry - there is no automatic instalation procedure yet, but you are programmer should be easily to do it.

To implement ajax view on your view, jQuery ajax has been encapsulate to be a simple function
<code>

	$(document).ready(function(){

		// classes
		var pukisRequest = new PUKISAPP.BEHAVIOR.PUKIS.ajax();

		// for every click on your view
		// pukisRequest.ajaxRequest(object, target, renderElement);
		// for link
		$('.users-users-admin-edit a').click(function(e){
			e.preventDefault();
			pukisRequest.ajaxRequest(this, this.href, '.body');
		});

		// for form
		// default ajax type is get, to change to post use
		// pukisRequest.ajaxType(type)
		$('.users-users-admin-edit form').submit(function(e){
			e.preventDefault();
			pukisRequest.ajaxType('post').ajaxRequest(this, this.action, '.body');
		});

		// default ajax data is null or form serialize it its post, to change for custum data
		// pukisRequest.ajaxData(data)
		$('.users-users-admin-edit form').submit(function(e){
			data = {id: 1, name: 'a name'}
			pukisRequest.ajaxType('post').ajaxData(data).ajaxRequest(this, this.action, '.body');
		});
	})

</code>

Hope this will simplify your projects

Wishlist :
Regarding the future development plan of this project, you also can give me ideas what to do.
- http://twitter.com/wmonou - Tweet me for wishlist
- http://wmonou.com - Visit my website for wishlist
