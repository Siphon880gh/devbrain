If there are too many lines of extra code and new elements introduced (like a script block acting as a template), which could make maintainability and reading harder for the developer, there are tricks.

Say you can have layout parts that are invisible at first via display none_ , but they also have the templating markup where they will be rendered. Your handlebars could read the template markup at that part of the layout then replace the rendered html into that same part of the layout, followed by making that part of the layout visible again. This reduces the coding complexity because you dont have to mentally jog about another element (script as the template) 

To make things even easier, you can have a script block with the data and render function right before the markdown (even though violates separation of concern, this is ok for personal projects or bootstrapped or agiled apps).

Note on repainting. If it’s obvious to user about the repainting, you can have a loading sprite take over entire page and hide the repainting stripe. You could also have the loading sprite at that part of the layout (by using absolutely positioned loading sprite inside the relative container). You can use visibility hidden with min height or width in place.

```
<!DOCTYPE html>  
<html lang="en">  
  
<head>  
    <meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Run App by Weng</title>  
  
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="bower_components/fontawesome/css/all.min.css">  
    <link rel="stylesheet" href="assets/index.css">  
    <link rel="manifest" href="manifest.json">  
    <link rel="apple-touch-icon" href="docs/ra-foot.png">  
    <link rel="icon" type="image/x-icon" href="docs/ra-glow.gif">  
    <link href="//cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.js"></script> <!-- Handlebar templating engine -->  
    <meta name="theme-color" content="#808080" />  
</head>  
  
<body>  
    <div class="container-fluid">  
        <header class="mb-4 text-center">  
            <h1 id="app-title">Run Programs <i class="fa-solid fa-person-running"></i></h1>  
            <i>By <a href="//wengindustry.com" target="_blank">Weng Fei Fung</a></i>  
            <section class="w-full flex flex-row justify-center gap-2 my-2">  
                <a target="_blank" href="https://github.com/Siphon880gh/run-app" rel="nofollow">  
                    <img src="https://img.shields.io/badge/GitHub--blue?style=social&logo=GitHub" alt="Github" data-canonical-src="https://img.shields.io/badge/GitHub--blue?style=social&logo=GitHub" style="max-width:10ch;"></a>  
                <a target="_blank" href="https://www.linkedin.com/in/weng-fung/" rel="nofollow">  
                    <img src="https://img.shields.io/badge/LinkedIn-blue?style=flat&logo=linkedin&labelColor=blue" alt="Linked-In" data-canonical-src="https://img.shields.io/badge/LinkedIn-blue?style=flat&amp;logo=linkedin&amp;labelColor=blue" style="max-width:10ch;"></a>  
                <a target="_blank" href="https://www.youtube.com/@WayneTeachesCode/" rel="nofollow">  
                    <img src="https://img.shields.io/badge/Youtube-red?style=flat&logo=youtube&labelColor=red" alt="Youtube" data-canonical-src="https://img.shields.io/badge/Youtube-red?style=flat&amp;logo=youtube&amp;labelColor=red" style="max-width:10ch;"></a>  
            </section>  
  
            <p class="pt-3 pb-3 d-block" style="width:75%; margin: 0 auto; font-weight:500;">Bring the app with you on your runs to train up to the next level!</p>  
               
            <div style="margin-left:30px; margin-right:30px;">  
                <p>Coming soon - 10 mile, half marathon, and marathon interactive plans. The walk, jog, and run durations are based on <a href="//exrx.net/Aerobic" target="_blank">ExRx.net</a>'s aerobic conditioning plans. I've also included "transitional" weeks for those who need a gradual transition to more challenging weeks, and they are denoted with a/b/c. Those more athletic can skip transitional weeks and follow the original ExRx.net's postings.</p>  
            </div>  
  
            <p style="display:flex; gap:15px; justify-content:center;">  
                <button class="btn-installer btn btn-primary btn-sm d-none">Install app</button>  
            </p>  
  
            <div style="position:fixed;top:5px; right:15px">  
                <button class="btn btn-sm" style="font-size:80%; background-color:lightgray;" onclick='  
                $("#myModal").modal(`show`);'><i class="fa fa-cog"></i>&nbsp;Settings</button>  
            </div>  
  
        </header>  
        <main class="programs row gx-5">  
            <!-- When you have more than one program, then use col-sm-6  
                 When only one program, then use col-sm-6-off  
                 When you upgrade jQuery to React, then use conditional rendering  
            -->  
            <article class="card-container col-12 col-sm-6 pt-2">  
                <div class="card">  
                    <div class="card-header">  
                        <h2>Goal: Run Continuously for 20 Minutes</h2>  
                        <i class="font-italic"><b>3-4x days per week</b></i><br/>  
                        <i class="font-italic">  
                            (<span style='color:#4E4E4E'>Gray a/b/c is an optional transition week if you need more conditioning</span>. It'll add a slower build up to the next week's intensity.<br/>  
                            <i class="font-italic">(<span style='color:#8b0000'>Red is difficult</span> for some individuals: May want to repeat week or add optional transitional weeks if you need more conditioning.)</i>  
                        </i>  
                    </div>  
                    <div class="card-body">  
                        <ul>  
                            <li>  
                                <a class="hover:text-red-400">  
                                    <span class="week-num">Week 0a</span>  
                                    <span class="fa fa-play" target="_blank" href="programs/run-20m/week0a.html"></span>  
                                </a>  
                                <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 1</span>  
                                <a class="fa fa-play" target="_blank" href="programs/run-20m/week1.html"></a>  
                                <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num" style='color: #4E4E4E'>Week 1b</span>  
                                <a class="fa fa-play" target="_blank" href="programs/run-20m/week1b.html"></a>  
                                <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 2</span>  
                                <a class="fa fa-play" target="_blank" href="programs/run-20m/week2.html"></a>  
                                <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num" style='color: #4E4E4E'>Week 2b</span>  
                                <a class="fa fa-play" target="_blank" href="programs/run-20m/week2b.html"></a>  
                                <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 3</span>  
                                <a class="fa fa-play" target="_blank" href="programs/run-20m/week3.html"></a>  
                                <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <li>  
                                    <span class="week-num" style='color: #4E4E4E'>Week 3b</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week3b.html"></a>  
                                    <span class="checkboxes">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                    </span>  
                                </li>  
                                <li>  
                                    <span class="week-num">Week 4</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week4.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                                <li>  
                                    <span class="week-num" style='color: #4E4E4E'>Week 4b</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week4b.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                                <li>  
                                    <span class="week-num" style='color:#8b0000'>Week 5</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week5.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                                <li>  
                                    <span class="week-num" style='color: #4E4E4E'>Week 5b</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week5b.html"></a>  
                                    <span class="checkboxes">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                    </span>  
                                </li>  
                                <li>  
                                    <span class="week-num">Week 6</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week6.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                                <li>  
                                    <span class="week-num" style='color: #4E4E4E'>Week 6b</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week6b.html"></a>  
                                    <span class="checkboxes">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                    </span>  
                                </li>  
                                <li>  
                                    <span class="week-num">Week 7</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week7.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                                <li>  
                                    <span class="week-num" style='color: #4E4E4E'>Week 7b</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week7b.html"></a>  
                                    <span class="checkboxes">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                    </span>  
                                </li>  
                                <li>  
                                    <span class="week-num">Week 8</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week8.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                                <li>  
                                    <span class="week-num" style='color: #4E4E4E'>Week 8b</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week8b.html"></a>  
                                    <span class="checkboxes">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                    </span>  
                                </li>  
                                <li>  
                                    <span class="week-num">Week 9</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week9.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                                <li>  
                                    <span class="week-num" style='color: #4E4E4E'>Week 9b</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week9b.html"></a>  
                                    <span class="checkboxes">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                    </span>  
                                </li>  
                                <li>  
                                    <span class="week-num">Week 10</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week10.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                                <li>  
                                    <span class="week-num" style='color: #4E4E4E'>Week 10b</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week10b.html"></a>  
                                    <span class="checkboxes">  
                                        <input type="checkbox">  
                                        <input type="checkbox">  
                                    </span>  
                                </li>  
                                <li>  
                                    <span class="week-num">Week 11</span>  
                                    <a class="fa fa-play" target="_blank" href="programs/run-20m/week11.html"></a>  
                                    <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                                </li>  
                        </ul>  
                    </div>  
                </div>  
            </article>  
  
  
            <article class="card-container col-12 col-sm-6 pt-2">  
                <div class="card">  
                    <div class="card-header">  
                        <h2>Goal: Run 1 mile to 5 miles</h2>  
                        <i class="font-italic">(4x days per week, May consecutive first 2 days)</i><br/>  
                        <i class="font-italic">(<span style='color:#8b0000'>Red is difficult</span> for some individuals: May want to repeat week or add optional transitional weeks if you need more conditioning.)</i>  
                    </div>  
                    <div class="card-body">  
                        <ul>  
                            <li>  
                                <span class="week-num">Week 1</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 2</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 3</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 4</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 5</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">1mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num" style="color:#8b0000;">Week 6</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num" style="color:#8b0000;">Week 7</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 8</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">2mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">4mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 9</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">4mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Week 9</span>  
                                <span class="checkboxes-with-labels">  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">3mi:</label>  
                                    <input type="checkbox">  
  
                                    <label onclick="checkNext(event)">5mi:</label>  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                        </ul>  
                    </div>  
                </div>  
            </article>  
  
            <!-- <article class="card-container col-12 col-sm-6 pt-2">  
                <div class="card">  
                    <div class="card-header">  
                        <h2>Testing new improvements: Please ignore this section.</h2>  
                        <i class="font-italic">Will remove once tests passed: Phases walk/run/jog steps through. End message appears. Restart a timer when clicked. Cues when a timer near finishes.</i>  
                    </div>  
                    <div class="card-body">  
                        <ul>  
                            <li>  
                                <span class="week-num">Test 1</span>  
                                <a class="fa fa-play" target="_blank" href="programs/test/week1.html"></a>  
                                <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                            <li>  
                                <span class="week-num">Test 2</span>  
                                <a class="fa fa-play" target="_blank" href="programs/test/week2.html"></a>  
                                <span class="checkboxes">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                    <input type="checkbox">  
                                </span>  
                            </li>  
                        </ul>  
                    </div>  
                </div>  
            </article> -->  
              
        </main>  
    </div>  
  
    <script src="bower_components/jquery/dist/jquery.min.js"></script>  
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>  
    <script src="sw-install-button.js"></script>  
    <script src="assets/index.js"></script>  
  
    <script>  
        if ('serviceWorker' in navigator) {  
            navigator.serviceWorker.register('sw.js', {  
                scope: 'https://therunner.app'  
            });  
        }  
    </script>  
</body>  
  
</html>
```