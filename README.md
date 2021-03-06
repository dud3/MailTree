@MailTree
=========

Simple mail forwarder.

Based on the specific email body/subject keywords forward mails to the list of predefined users.

Install
--------

**Imap**

Install imap dependency. <br>
``apt-get install php5-imap``

Add to the end of "php.ini" file.<br>
``extension=imap.so``

**Composer**

cd to the root folder of tha app:<br>
``composer install``<br>
<i>This will install all PHP dependencies.</i>

**grunt**

cd to the the ``/public`` directory:<br>
``grunt install``<br>
<i>This will install all javaScript dependencies.</i>


Artisan Commands
-----------------
**Clean all emails from the DB:**
```sh
./artisan email:clean
```

**Read Emails:**
```sh
./artisan email:read --html_enable=bool --email_search=string
```
<i>Options:</i>
<br>
``--html_enable`` - Boolean(true/false) - which basically specifies if the email should include "HTML" tags or be only plain text.
<br>
``--email_search`` - Read email based on it's state(see: <i>~Imap_search Values</i> section below)

**Send Emails:**
```sh
./artisan email:send
```

**Clean Dump Files**
```sh
./artisan dumpFile:clean
```

### @Imap_search Values
```text
ALL - return all messages matching the rest of the criteria
ANSWERED - match messages with the \\ANSWERED flag set
BCC "string" - match messages with "string" in the Bcc: field
BEFORE "date" - match messages with Date: before "date"
BODY "string" - match messages with "string" in the body of the message
CC "string" - match messages with "string" in the Cc: field
DELETED - match deleted messages
FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
FROM "string" - match messages with "string" in the From: field
KEYWORD "string" - match messages with "string" as a keyword
NEW - match new messages
OLD - match old messages
ON "date" - match messages with Date: matching "date"
RECENT - match messages with the \\RECENT flag set
SEEN - match messages that have been read (the \\SEEN flag is set)
SINCE "date" - match messages with Date: after "date"
SUBJECT "string" - match messages with "string" in the Subject:
TEXT "string" - match messages with text "string"
TO "string" - match messages with "string" in the To:
UNANSWERED - match messages that have not been answered
UNDELETED - match messages that are not deleted
UNFLAGGED - match messages that are not flagged
UNKEYWORD "string" - match messages that do not have the keyword "string"
UNSEEN - match messages which have not been read yet
```

Examples
--------

#### Login
![ScreenShot](https://raw.githubusercontent.com/dud3/e_fwd/master/public/app_samples/e_fwd-signin.png)

#### Keywords Page
![ScreenShot](https://raw.githubusercontent.com/dud3/MailTree/master/public/app_samples/keywords_page.png)

#### Mails Page
![ScreenShot](https://raw.githubusercontent.com/dud3/MailTree/master/public/app_samples/mails-p.png)

#### Left Pane
![ScreenShot](https://raw.githubusercontent.com/dud3/MailTree/master/public/app_samples/mailtree-leftpane.png)

Copyright and License
=====================
Code and documentation copyright 2011-2014 @dud3(Dren Kajmakci). Code released under the GPLv2 license.

```text
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
```
