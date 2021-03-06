create table users(userid bigint primary key auto_increment, first_name varchar(32) not null, last_name varchar(64) not null, email varchar(200) not null unique, password varchar(100) not null, address1 varchar(100), address2 varchar(100), city varchar(100), state char(2), zip varchar(32), phone varchar(30), biography text, resume text)
create table bugs(bugid bigint primary key auto_increment, userid bigint references users, bugtext text, type integer, bugdate date)
create table forums(forumid bigint primary key auto_increment, title varchar(100), details text)
create table posts(postid bigint primary key auto_increment, parent bigint, forumid bigint references forums, subject varchar(200), post text, postdate date, userid bigint references users)
create table articles(articleid bigint primary key auto_increment, posted date, title varchar(100) not null, article text, userid bigint references users)
create table schedule(scheduleid bigint primary key auto_increment, starttime timestamp, endtime timestamp, details text, title varchar(100), userid bigint references users)
create table files(fileid bigint primary key auto_increment, filepath text, filename varchar(100), url text)
create table emails(emailid bigint primary key auto_increment, subject text, body text)
create table notification(notifid bigint primary key auto_increment, userid bigint references users, emailid bigint references emails, send set('t','f'))
create table trees(treeid bigint primary key auto_increment, title varchar(100))
create table categories(treeid bigint references trees, catid bigint primary key auto_increment, parent bigint, title varchar(100), details text)
create table items(itemid bigint primary key auto_increment, tablename varchar(50), id bigint)
create table rights(rightid bigint primary key auto_increment, userid bigint, canadmin set('t','f'), canread set('t','f'), canwrite set('t','f'), itemid bigint references items)
create table pages(pageid bigint primary key auto_increment, page varchar(255) not null unique)
create table catrel(catrelid bigint primary key auto_increment, itemid bigint references items, treeid bigint references trees, catid bigint)
create table polls(pollid bigint primary key auto_increment, question varchar(100), atext varchar(100), btext varchar(100), ctext varchar(100), dtext varchar(100), avotes bigint, bvotes bigint, cvotes bigint, dvotes bigint, votes bigint)
insert into users(first_name,last_name,email,password) values('Marcos','Elugardo','marcos@castirondesign.com','marcos')
insert into items(tablename,id) values('',0)
insert into rights(userid,canadmin,canread,canwrite,itemid) values(1,'t','t','t',1)
insert into emails(subject,body) values('New Article','#article_url#')
insert into emails(subject,body) values('New Forum Post','#forumpost_url#')
insert into emails(subject,body) values('New Event','#event_url#')
insert into trees(title) values ('Articles')
insert into items(tablename,id) values('trees',1)
insert into categories(treeid,parent,title,details) values (1,0,'General Articles','This category is for general articles')
insert into items(tablename,id) values('categories',1)
insert into polls(question,atext,btext,ctext,dtext,votes) values('What do you think of this site?','Incredible!','Good','Ok','Awful',0)