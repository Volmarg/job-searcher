<p align="center">
<img src="https://github.com/Volmarg/job-searcher/blob/master/github/logo.png?raw=true" width="150px;" />
</p>

<h1 align="center"> Job Searcher </h1>
<p align="center"><i>Optimize Your job searching time</i></p>

<h3>Description</h3>
<hr>
<p align="justify">
    This tool works with a variety of job portal like <b>indeed.com</b> or <b>Glassdoor.com</b> - it searches through the search result pages, extract the job offers with their descriptions and headers, marks the accepted/rejected keywords and displays the summary status (if job offer is anyhow suitable or not - keep in mind that this is just a tool so it's not perfect in this term). Additionally: search settings can be saved for future reusage and emails templates can be used to speed up mailing process.
</p>

<h3>Reasoning/Purpose</h3>
<hr>

<p align="justify">
    First of all this is rewritten version of older project (it was first attempt to create something with framework - code was ugly, unmaintinable, unreusable - general mess created before I learned how to maintain and create pretty codebase).
</p>

<p align="justify">
    Now the reason itself is pretty simple - I was sick and tired of scrolling through the job offers over and over and over just to find on its end that I actually don't fit in due to some missing skills where magically out of nowhere after entire php/js description it's required to know C#... Other natural case - why even bothering reading the offers when You barely get response from any at all, or You see email addresses like <b>recrutation@spam.domain.com</b>.
</p>

<p align="justify">
    With this I decided that I don't want to waste any more time on such useless job searching, as rude as it sounds it's just not worth it, and with this tool i can just open scanned job offer in tool, take a quick look which keywords are ok/not-ok, what is the status, and hey I can even generate email for every job offer separately.
</p>

<h3>Available options</h3>
<hr>

<ol>
    <li><b style="display:inline">🔎 Job searching </b> - <span align="justify"><i>Scraps the job offers details from given search result pages based on provided criteria</i>
        </span></li><br/>
        <li><b>💾 Search settings</b> <span align="justify"> - <i>It can take some time to set up the proper criteria to scan given pages - with this You can save Your settings and reuse them for example next week, or just change some keywords and save them as new setting,</i></span></li><br/>
        <li><b>📨 Mail templates</b> - <span align="justify"> <i>Create mail template which can be used to generate mail content upon displaying search results.
            </i></span></li><br/>
</ol>

<h2>Preview</h2>

<p align="center">Fully accessible demo can be found <a href="http://185.204.216.136:8002"><b>⇛Here⇚</b></a>.</p>
<p align="center"><i><b>Info!</b> All data is removed daily - so better don't store any settings here.</i></p>

<img src="https://github.com/Volmarg/job-searcher/blob/master/github/screen1.jpg?raw=true">

<hr>	
	
<img src="https://github.com/Volmarg/job-searcher/blob/master/github/screen2.jpg?raw=true">

</div>

<hr>

<h2>How to install</h2>

- Requirements
  - Php 7.2.x
  - php7.2-curl
  - php7.2-sqlite
  - https://symfony.com/download 
    - wget https://get.symfony.com/cli/installer -O - | bash
    - mv /root/.symfony/bin/symfony /usr/local/bin/symfony
- Clone my repository
- Inside the repository run:
  - composer install
  - create <b>.env</b> file with content
	````
	APP_ENV=prod
	APP_DEBUG=false

	APP_SECRET=eb0b9c7a18f777b1ceafae71882873cc

	DATABASE_URL=sqlite:///%kernel.project_dir%/var/database.db
	````
  - bin/console cache:clear
  - bin/console cache:warmup
  - bin/console doctrine:database:create
  - bin/console doctrine:schema:create
  - symfony server:start --port=8001


<h2>How to use</h2>

<p align="justify">
<i>
	You will need to analyse the job offer page to get the parameters used for job searching.
</i>
</p>

- Example job portal: https://indeed.com/
- Make a search on this page like this: https://www.indeed.com/jobs?q=php+developer&l=New+York%2C+NY
- Now go to second pagination: https://www.indeed.com/jobs?q=php+developer&l=New+York%2C+NY&start=10
- As You can see the pagination url contains now:
  - start=10
- Now go to next page: https://www.indeed.com/jobs?q=php+developer&l=New+York%2C+NY&start=20
  - start=20
- With this we just found:
  - <b>Page offset steps:</b> 10 (each pager increments the value by 10), 
  - <b>Url pattern: </b> https://www.indeed.com/jobs?q=php+developer&l=New+York%2C+NY&start={number} (place where the number in url changes)
   - <b>Page offset replace pattern: </b> the pattern that You used above (in this case {number})
 - By knowing the offset You can decide how many pages You want to search - lets say from page 1 (10) to 5 (50)
   - <b>Start page offset: </b> 10
   - <b>End page offset: </b> 10
- Go to: https://www.indeed.com/jobs?q=php+developer&l=New+York%2C+NY&start=10
   - use dev tool to find out what is the <i>css</i> selector for <b>A</b> tag with link to offer details (<b>Link query selector</b>)
- Open one of the offers <b> in new window(!)</b>: https://www.indeed.com/viewjob?jk=4186f34508d6716e&tk=1dtp90jft0mpf000&from=serp&vjs=3
  - use dev tool to find out what is the <i>css</i> selector for job title, (<b>Header query selector</b>)
  - use dev tool to find out what is the <i>css</i> selector for job description, (<b>Body query selector</b>)
- if there are some annoying job links based on ads - You can prepare regex which will be used to skip links that match given regex (<b>Do not insert flags and limiters like #/</b>)
- provide accepted/rejected keywords by which the offer will be <b>judged</b>, (<b>at least one keyword is required for each keywords fields. Add keyword and hit enter to save it in input</b>)

<h2>Future development plans</h2>

<h3>Improvements</h3>
<p>
	<i>I'm not really planning anything super fancy here, so most likely i will just update bugs from time to time when I find some and add small features which I'll consider helpful.</i>
</p>	
<hr>

<h2>Browsers Support</h2>
<p>
	I recommend using this tool on <b>Chrome</b> - I'm just using it in 99% cases so I don't even bother testing it on other browsers as I just don't use them.
</p>

<hr>

<h2>Tech</h2>
<p style="text-align:justify;">
	<b>Job Searcher</b> is a web application which can be ran either in Windows and Linux environment. Everything is by default tested on Ubuntu 18.x.
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
<li><a href="https://github.com/selectize">Selectize</a> <small>(Tags/arrays in inputs)</small></li>
<li><a href="https://github.com/makeusabrew/bootbox">Bootbox</a> (<small>Modals</small>)
</li>
<li><a href="https://github.com/DataTables/DataTables">DataTables</a> <small>(Better tables)</small></li>
<li><a href="https://github.com/mouse0270/bootstrap-notify">BootstrapNotify</a> (<small>Notifications</small>)</li>
</ul>

<h2>FAQ</h2>

1. <b>Does it work?</b>
<p>
<i>
Depends what You mean by this. As tool itself - yes it works. If You ask if It helps finding a job then the answer is... yes. At some point I did found jobs thanks to this tool - and by "found" i mean that I actually physically was in company and worked there.
</i>
</p>

2. <b>Can You make it more... automatic?</b>
<p>
<i>
No. Not a single chance, that's just not worth it as in many cases You need to login on given platform and just paste the mail alongside with adding attachments. There are very few cases where email addresses are directly pointed in the offer.
</i>
</p>

3. <b>Can You maybe make email sending directly from the tool</b>
<p>
<i>
This is possible to be done but answering - no, just not worth it - look at point above.
</i>
</p>

4. <b>So.. this is basically small spam bomb?</b>
<p>
<i>
You can call it this way if You want that means if You are fast, got 2/3 screens then yes it turns into spam bomb. I prefer calling it <b>"job searcher"</b>.
</i>
</p>

5. <b>Isn't it rude to just spam mails without reading offers?</b>
<p>
<i>
If You don't like something then try to change it, if not then drop it. Can I optimize my job searching time according to all the ignored emails and so on? Yes - so I changed it - the tool is just an answer for never-ending story of useless offers reading where on the end 80% of applications are ignored, because some want <b>20 years experience while being 18 years old</b>, <b>guy for everything (unicorn developer)</b> or because <b>someone wanted less payment</b>.
</i>
</p>

6. <b>Does it work with all job portals?</b>
<p>
<i>
	No. If this for example fully <b>Angular</b> based portal then there is no chance that my solution will work. There is a way to handle such portals as well but I'm not doing this.
</i>
</p>

