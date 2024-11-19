```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Weng's Rapid Development Tool -->
    <!-- This is a great way to get started and to get feedback from stakeholders with shorter iteration cycles. -->
    <!-- By minimizing the need for js files because of inline attributes for fetching, state, and rendering -->
    <!-- with alpine js, minizing the need for css files by using styling classes from bootstrap and tailwind  -->
    <!-- you can write HTML, CSS, JS seamlessly left to right. In addition, the whenLive syntax makes your coding -->
    <!-- logic easier when it comes to dynamically generated content that needs event listeners. If you have to write -->
    <!-- javascript, plugins like jQuery will shorten the amount of typing, in some cases up to a quarter of time -->
    <!-- Eg. document.querySelector(".target").forEach(el=>... versus a simple $(".target"). Furthermore, underscore js --> 
    <!-- is also included to make coding certain js logic easier to read and think in. All this so you don't have to juggle -->
    <!-- different files, don't have to juggle different ways of thinking, and can seamlessly conceptualize and code simultaneously -->
    <!-- This accelerates development time. But once your prototype is well received by stakeholders, you can pivot to converting -->
    <!-- the code into performant code by moving the script files to the bottom of body block and converting away from jQuery, whenLive, etc -->

    <!-- Syntactic Sugar: JS Logic -->
    <script data-docs="https://underscorejs.org/" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.6/underscore-min.js" integrity="sha512-2V49R8ndaagCOnwmj8QnbT1Gz/rie17UouD9Re5WxbzRVUGoftCu5IuqqtAM9+UC3fwfHCSJR1hkzNQh/2wdtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script data-docs="https://api.jquery.com/" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha512-DUC8yqWf7ez3JD1jszxCWSVB0DMP78eOyBpMa5aJki1bIRARykviOuImIczkxlj1KhVSyS16w2FSQetkD4UU2w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script data-docs="https://github.com/tkambler/whenLive/" src="https://rawcdn.githack.com/tkambler/whenLive/4574d3b022012677f1f6d61309a91673c4878f51/src/jquery.whenlive.js"></script>
    
    <!-- Syntactic Sugar: Logic inline with html -->
    <script data-docs="https://alpinejs.dev" src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.min.js" integrity="sha512-Atu8sttM7mNNMon28+GHxLdz4Xo2APm1WVHwiLW9gW4bmHpHc/E2IbXrj98SmefTmbqbUTOztKl5PDPiu0LD/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Syntactic Sugar: Style classes inline with html -->
    <link data-docs="https://getbootstrap.com/docs/5.0/" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link data-docs="https://v2.tailwindcss.com/docs" href="https://rawcdn.githack.com/Siphon880gh/css-frameworks/d3ae7766c51815c4e630d0e734c46bf596956694/assets/vendors/tailwind2/no-normalizer/tailwind.min.css" rel="stylesheet">

    <!-- Icon Sets -->
    <link data-docs="https://fontawesome.com/v5/search?o=r&m=free" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" rel="stylesheet">

    <template role="Delete if not needed - Run when new element dynamically created">
        $(".elem").whenLive( el => {
            $(el).click(()=>{
                console.log("Newly created ", el);
            });
        }); // whenLive
    </template> <!-- Ends whenLive -->

    <template role="Delete if not needed - Rendering templates that interpolate values and have rendering logic">
        <!-- Template Rendering System - Handlebars -->
        <script 
            data-docs="https://handlebarsjs.com/guide/#what-is-handlebars" 
            data-playground="https://handlebarsjs.com/playground.html"
            src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.js">
        </script>

        <script role="Handlebars Helpers">
            Handlebars.registerHelper('loud', function (aString) {
                return aString.toUpperCase()
            })
        </script>

        <script>
            var template = $("#template").clone().html();
            var context = { firstname: "John", lastname: "Doe" };
            var parameterizedTemplate = Handlebars.compile(template);
            var generatedHtml = parameterizedTemplate();
            $(".container").append(generatedHtml);
        </script>

        <template id="template">
            <label>First name: </label><input id="first-name" value="{{firstname}}">
            <label>Last name: </label><input id="first-name" value="{{loud lastname}}">
        </template>

    </template> <!-- Ends Handlebars -->

    <template role="Delete if not needed - Access content of iframe or iframe's parent">
        // We are inside iframe and want to access parent window
        var parentWindow = window.parent.document;
        
        // We want to access an iframe's content
        var iframeWindow = document.querySelector('iframe').contentWindow;
    </template> <!-- Ends iFrame syntactic sugar -->
        
    <template role="Move lines into production code if applicable - Keep block if no image content yet">
        <img src="https://placekitten.com/408/287" alt="Placeholder"/>
        <img src="https://place-hold.it/250x100?text=Placeholder" alt="Placeholder"/>
    </template> <!-- Ends Placeholders -->

    <template role="Move lines into production code if applicable - Keep block if unsure of future features">   
        
        <!-- Bootstrap Interactive Elements -->
        <script data-docs="https://getbootstrap.com/docs/5.0/" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

        <!-- Data Visualization (Tables and Graphs) -->
        <script data-docs="https://d3js.org/getting-started" src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js" integrity="sha512-M7nHCiNUOwFt6Us3r8alutZLm9qMt4s9951uo8jqO4UwJ1hziseL6O3ndFyigx6+LREfZqnhHxYjKRJ8ZQ69DQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script data-docs="https://datatables.net/manual/index" data-dependency="jquery" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script data-docs="https://datatables.net/extensions/index" src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
        <script data-docs="https://datatables.net/extensions/index" src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
    
        <!-- Markdown Rendering -->
        <script data-docs="https://www.jsdelivr.com/package/npm/markdown-it" src="https://cdn.jsdelivr.net/npm/markdown-it@13.0.2/dist/markdown-it.min.js"></script>

        <!-- jQuery UI Components and Interactive Behaivors -->
        <!-- jQuery UI Touch Punch enables interactive behaivors onto mobile -->
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    </template> <!-- Ends Other Features -->
</head>
<body>
    Test
</body>
</html>
```