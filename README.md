<p align="center">
<img src="https://github.com/Volmarg/personal-management-system/blob/beta1.0/public/assets/images/logo/smaller.png?raw=true" width="150px;" />
</p>
<p align="center">
<img src="https://github.com/Volmarg/personal-management-system/blob/main/github/bar.jpg?raw=true" />
</p>

<h1 align="center"> Job Searcher </h1>
<p align="center"><i>Optimize Your job searching time</i></p>

<h3>Description</h3>
<hr>
<p align="justify">
    This tool works with variety of job portal like <b>indeed.com</b> or <b>linkedin.com</b> - it searches through the search result pages, extract the job offers with their descriptions and headers, marks the found/rejected keywords and displays the summary status (if job offer is anyhow suitable or not - keep in mind that this is just a tool so it's not perfect in this terms). Additionaly: search settings can be saved for future reusage and emails templates can be used to speed up mailing process.
</p>

<h3>Reasoning/Purpose</h3>
<hr>

<p align="justify">
    First of all this is rewritten version of older project ( first attempt to create something with framework - code was ugly, unmaintinable, unreusable - general mess created before I learned how to maintain and create pretty codebase).
</p>

<p align="justify">
    Now the reason itself is pretty simple - I was sick and tired of scrolling through the job offers over and over and over just to find on it's end that I actually don't fit in due to some missing skills where magically out of nowhere after entire php/js description it's required to know C#... Other naturall cases - why even bothering reading the offers when You barely get response from any at all, or You see email adresses like `recrutation@spam.domain.com`.
</p>

<p align="justify">
    With this I decided that I don't want to waste any more time on such useless job searching, as rude as it sounds it's just not worth it, and with this tool i can just open `scanned` job offer in tool, take a quick look which keywords are ok/not-ok, what is the status, and hey I can even generate email for every job offer separatelly.
</p>

<h3>Available options</h3>
<hr>

<ol>
    <li><b style="display:inline">🎯 Job searching </b> - <span align="justify"><i>Scraps the job offers details from given search result pages based on provided cryteria</i>
        </span></li><br/>
        <li><b>📖 Search settings</b> <span align="justify"> - It can take some time to set up the proper cryteria to scan given pages - with this You can save Your settings and reuse them for example next week, or just change some keywords and save them as new setting,</span></li><br/>
        <li><b>📞 Mail templates</b> - <span align="justify"> Create mail template wich can be used to generate mail content upon displaying search results.
            </span></li><br/>
</ol>

<h2>Preview</h2>

<p align="center">Fully accessible demo can be found <a href="http://185.204.216.136:8001"><b>⇛Here⇚</b></a>.</p>
<p><i><b>Info!</b> All data is removed daily - so better don't store any settings here.</i></p>

<img src="https://github.com/Volmarg/personal-management-system/blob/main/github/1.20_contacts.jpg?raw=true">

<hr>	
	
<img src="https://github.com/Volmarg/personal-management-system/blob/main/github/preview2.png?raw=true">

<hr>

<img src="https://github.com/Volmarg/personal-management-system/blob/main/github/preview3.png?raw=true">
</div>

<hr>

<h2>How to install/documentation</h2>
<p>
You can find all the informations <a href="https://volmarg.github.io"><b>⇛Here⇚</b></a>.
</p>

<h3> Linux installer </h3>
<p>
	The project can also be installed by simply calling <b>composer install</b> in project root folder <b>(Read the information that will popup)</b>.
You will be guided through the autoinstaller - it won't do everything for You but will attempt to help You setting up the project.
</p>

<h2>Future development plans</h2>

<h3>Improvements</h3>
<p>
	<i>I'm not really planning anything super fancy here, so most likely i will just update bugs from time to time when I find some and add small features which I'll consider helpfull.</i>
</p>	
<hr>

<h2>Support</h2>

<p align="justify">
    I cannot guarantee support. I've got a job, personal things etc, I'm just sharing my code/my application as MIT. However feel totally free to ask about something, write issues etc. As mentioned I'm using and I will use this application from now on daily so there might be some changes even good for me.
</p>

<p align="justify">
    As I'm working on it there will be some fixes, and new modules in future when I reach the point when I got all I need. So after reaching my goal I could handle some support requests if anyone will be interested.
</p>

<h3>Browsers Support</h3>
<p>
	I recommend using this tool on <b>Chrome</b> - I'm just using it in 99% cases so I don't even bother testing it on other browsers as I just don't use them.
</p>

<hr>

<h2>Tech</h2>
<p style="text-align:justify;">
    Job Searcher is a web application which can be ran either in Windows and Linux enviroment. Everything is by default tested on Ubuntu 18.x.
</p>

<h3>Used languages/frameworks/solutions</h3>

<ul>
<li>Php 7.2.x</li>
<li>JS</li>
<li>JQ</li>
<li>Symfony 5.0.1</li>
<li>SQLite</li>
<li>Css</li>
</ul>

<h3>Used packages</h3>
<ul>
<li><a href="https://github.com/iamshipon1988/bootadmin">Bootadmin</a> <small>(Ui)</small></li>
<li><a href="https://github.com/tinymce/">Tinymce</a> <small>(Editor)</small></li>
<li><a href="https://github.com/selectize">Icon Picker</a> <small>(Tags/arrays in inputs)</small></li>
<li><a href="https://github.com/makeusabrew/bootbox">Bootbox</a> (<small>Additional safety confirmations for CRUD</small>)
</li>
<li><a href="https://github.com/DataTables/DataTables">DataTables</a> <small>(Better tables)</small></li>
<li><a href="https://github.com/mouse0270/bootstrap-notify">BootstrapNotify</a> (<small>Notifications</small>)</li>
</ul>

<h2>FAQ</h2>

1. Does it work?
<p>
<i>
Depends what You mean by this. As tool itself - yes it works. If You ask if It helps finding a job then the answer is... yes. At some point I did found jobs thanks to thins tool - and by "found" i mean that I atually physically was at company and worked there.
</i>
</p>

2. Can You make it more... automatic?
<p>
<i>
No. Not a single chance, that's just not worth it as in many cases You need to login on given platform and just paste the mail alongside with adding attachments. There are very few cases where email adresses are directly pointed in the offer.
</i>
</p>

3. Can You maybe make email sending directly from the tool
<p>
<i>
This is possible to be done but answering - no, just not worth it - look at point above.
</i>
</p>

4. So.. this is basically small spam bomb?
<p>
<i>
You can call it this way if You want that means if You are fast, got 2/3 screens then yes it turns into spam bomb. I prefer calling it "job searcher".
</i>
</p>