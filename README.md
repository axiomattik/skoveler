# skoveler

> A SPA that provides a tool for outlining a novel.

If you're going to outline a novel (or any form of structured fiction) then probably the best solution is to grab a pencil and some paper (maybe a ruler too) and go at it manually in the old-fashioned way. This worked [perfectly well](https://flashbak.com/jkrowling-sketches-harry-potter-plot-spreadsheet-400969/) for J.K. Rowling.

However, for whatever reason, I've found myself on more than one occasion writing html tables from scratch in order to avoid the tedium of drawing boxes that will end up too small or too big or having to start the whole thing over because I've realised chapter 5 is actually chapter 2 and so on. 

The fact I find writing raw HTML less tedious than either paper probably says something vaguely important about my psyche that may or may not be worth paying attention to.

Raw HTML has quite a few limitations. It's not pleasant to edit. Reordering table rows is cumbersome. And I have to alternate between a text editor and a browser when I'm either editing or surveying. I found myself wanting to be able to change the order of the table rows in browser, or edit their contents, or select a different colour, or, depending on what I was doing, to sort them chronologically, by setting, title or by chapter. 

These are all things that could be achieved using Excel. Pretty much my only reasons for not using Excel are wanting the table layout to be decided for me automatically (Excel can probably do that) and wanting the UI to be as simple and specific to the task as possible. 


## Stack

My initial inclination is to reach for Vue.js, Laravel and SQLite3. However, I have this niggling feeling that, since this is a relatively simple application, using frameworks would be overkill. I am going to build a prototype from scratch first and then maybe later I will use a more conventional stack. The idea being that building from scratch I'm a) going to learn something and b) going to end up with a more concrete understanding of the value Vue.js and Laravel bring to the table.




## Users

When a user visits Skoveler, they are given the option of either logging in or continuing as a guest. If the log in successfully using valid credentials, the server sends a secret key which is stored as a cookie by the client and used to authenticate future requests. When a user attempts to perform an action, such as creating a new novel or chapter, or accessing the novel(s) of a specific user, etc.., the client uses the cookie to authenticate and then checks the user's 'role' in the 'account' table of the database. Current roles are: 'guest', 'user', admin 'admin'.

If the user chose to continue as a guest, then a new empty user with the role of 'guest' is created in the database and the client is provided with a secret key. The guest account functions exactly as a real 'user' account, with perhaps some limitated privileges, but if the client loses the cookie secret, then any work associated with the guest account will not be recoverable using a username and password.





