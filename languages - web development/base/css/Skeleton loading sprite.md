
Define the skeleton gray backgrounds in HTML:
```
<div id="skeleton-explorer" style="padding:5px; border-radius:5px; display:inline-block; margin-top:5px; text-align:left; margin-bottom:10px; width:100%; height:400px;" class="d-none">


                            <div style="padding:15px; display:flex; flex-flow:column nowrap; align-items: flex-end;">

                                <div style="margin-top:5px;">
                                    <div id="skeleton-1" class="skeleton" style="background-color:lightgray;"> </div>

                                </div>

                                <div style="margin-top:5px;">


                                    <div id="skeleton-2" class="skeleton" style="background-color:lightgray;"> </div>

                                </div>

                            </div>


                            <br>

                            <div>
                                <ul style="color:lightgray;">
                                    <li style="margin: 5px 0;">
                                        <div class="skeleton" style="display:inline-block; width: 40%; background-color:lightgray;">
                                            &nbsp;</div>
                                    </li>
                                    <li style="margin: 5px 0;">
                                        <div class="skeleton" style="display:inline-block; width: 40%; background-color:lightgray;">
                                            &nbsp;</div>
                                    </li>
                                    <li style="margin: 5px 0;">
                                        <div class="skeleton" style="display:inline-block; width: 40%; background-color:lightgray;">
                                            &nbsp;</div>
                                    </li>
                                    <li style="margin: 5px 0;">
                                        <div class="skeleton" style="display:inline-block; width: 40%; background-color:lightgray;">
                                            &nbsp;</div>
                                    </li>
                                    <li style="margin: 5px 0;">
                                        <div class="skeleton" style="display:inline-block; width: 40%; background-color:lightgray;">
                                            &nbsp;</div>
                                    </li>
                                    <li style="margin: 5px 0;">
                                        <div class="skeleton" style="display:inline-block; width: 40%; background-color:lightgray;">
                                            &nbsp;</div>
                                    </li>
                                    <li style="margin: 5px 0;">
                                        <div class="skeleton" style="display:inline-block; width: 40%; background-color:lightgray;">
                                            &nbsp;</div>
                                    </li>
                                    <li style="margin: 5px 0;">
                                        <div class="skeleton" style="display:inline-block; width: 40%; background-color:lightgray;">
                                            &nbsp;</div>
                                    </li>
                                </ul>
                            </div>

                        </div>
```

Animation Preview:
![](https://i.imgur.com/0EXsw4t.png)


![](https://i.imgur.com/1g9jdpY.png)


![](https://i.imgur.com/eYvA03r.png)

Then in CSS, add a forward slash that animates across the gray skeleton backgrounds. Notice each gray skeleton background has the class skeleton. Notice I have ID's skeleton-1 and skeleton-2 which are to show different sized backgrounds depending on mobile or desktop, demonstrating that the skeleton can still fit your responsive designs

```
        .skeleton {
            width: 100%;
            height: 20px;
            background: lightgray;
            position: relative;
            overflow: hidden;
        }

        .skeleton::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            transform: rotate(-45deg);

            /* Diagonal sprite sliding left to right and repeats from left but edge looked too sharp, so blurring it*/
            filter: blur(10px);
            animation: shine 1.5s infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(-45deg);
            }

            100% {
                transform: translateX(200%) rotate(-45deg);
            }
        }
        #skeleton-1 {
            width: 530px;
            height:27px; 
        }
        #skeleton-2 {
            width: 400px;
            height:27px; 
        }
        @media screen AND (max-width:768px) {
            #skeleton-1 {
                width:50vw;
            }
            #skeleton-2 {
                width:50vw;
            }
        }
```