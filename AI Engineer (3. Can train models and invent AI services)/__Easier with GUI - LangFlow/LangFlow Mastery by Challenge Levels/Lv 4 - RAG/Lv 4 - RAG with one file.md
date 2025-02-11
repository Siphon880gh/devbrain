GOAL: RAG test with a small text file first. We use small text embedding model from OpenAI. This is to limit cost and so we can quickly see that the RAG works. After working, you can adapt it for multiple PDF files (Hint: Use "Directory" component instead of "File" component)

---


Open the RAG starter template. You'll be presented with a "1. Load Data Flow" and "2. Retrieve Flow":
- Btw the "Parse Data" component is now renamed to "Data to Message" component in Lang Flow's library. 
![](KxjigDH.png)

Sneak peak:
- We will load in you PDFs or text files at "1. Load Data Flow"
- Then at "2. Retrieve Flow", we can query the PDFs or text files about anything

The external connections needed:
- You'd need an external text embedding model - OpenAI offers one.
- You also need a vector database. DataStax offers a free 10gb AstraDB.

These are the credentials and database/collection details missing:
- At Loading (aka Load file): Missing API key at OpenAI text embedding model, missing token / database name / collection name at AstraDB vector database.
- At Retrieval (aka Query): Same missing items, plus missing API key for OpenAI LLM chat model.

**Quick Orientation:**
- At loading data, your file is chunked over to a text embedding model that knows how to vectorize your words into a queryable vector database. It saves the vectors to your queryable vector database.
- At retrieval (aka prompting), your Chat Input will search for the relevant answers in the queryable vector database, using the same text embedding model to do so. The relevant answer (aka variable `{context}` ) and your Chat Input (aka variable `{question}` ) gets passed into ChatGPT model, then it rewords the combined text into a prompt response. The only generative part was from AstraDB, and ChatGPT was use for transformation (rewording). Here’s ChatGPT’s transformation work:
```
{context}

---

Given the context above, answer the question as best as possible.

Question: {question}

Answer: 
```

  Remember you must first ingest the data (which enhances the AI with your documents, usually by you loading documents in), before you can retrieve (aka prompt the model!). That is RAG - Retrieval-augmented generation.

---

**Get API Key for Text embedding model and ChatGPT**

Get your API key for your project at platform.openai.com

Make sure to enable the text embedding models as well as the ChatGPT model you'll be using. For our example, we will use a small text embedding model:
[https://platform.openai.com/settings](https://platform.openai.com/settings)
![[Pasted image 20250210234531.png]]


**Enter** your API key at the LangFlow canvas, specifically at:
- Load flow's text embedding model
- Retrieval flow's text embedding model and ChatGPT model

---

**Get AstraDB connection details**

https://astra.datastax.com/
Get Free.
What free means
- for the first 10GB
- when inactive, it takes minutes to warm up the database again (meanwhile, will fail)

**Create database** at astradb web dashboard. You can name it something like "test" or something more distinguishable for your RAG use case. It will pend finish initializing. Wait for it to finish. Could take minutes.

Get **application token** under the database:
![[Pasted image 20250210234939.png]]

**DO NOT** create the collection at AstraDB web dashboard. We will create the collection through LangFlow (LangFlow will properly structure your collection at an api call to AstraDB under the hood). 
- FYI: If you do create the collection manually at AstralDB web dashboard, you have to structure the collection correctly including having a content field and including selecting it to be structured for the same text embedding model (default is Nvidia instead of OpenAI text embeddings) and you may need to use their CQL console to do so.

**Enter** your token and database name at the LangFlow canvas, specifically at:
- Load flow's AstraDB component
- Retrieval flow's AstraDB component
- **LEAVE ALONE** collection name

---

**Double check the API and DB details are entered**

Load flow looks like:
![[Pasted image 20250211020132.png]]

Retrieval flow looks like:
![[Pasted image 20250211020456.png]]

---


**Have Langflow create the AstraDB collection**

At Loading and Retrieval, your AstraDB component should be filled in at the token and database name fields. For this tutorial, I've named the database name "test":
![[Pasted image 20250210235509.png]]

^FYI: Note that not ALL of the inputs need to be connected. Regardless of Load flow or Retrieval flow, the same inputs are available because there is only one version of the AstraDB component. What mattered is which inputs are connected to and then empty fields are ignored

Let's go into Collection to type in a collection name. We will name it "name" or you can name it for your RAG use case:
![[Pasted image 20250210235651.png]]

This will have LangFlow automatically create the collection for you at AstraDB because the collection doesn't exist there. That is fine.


----

**Load in content for RAG**

Small text file on Knights of Templar history vectorized for RAG (you can collapse/expand this):
> [!note] Knights_Templar.txt
> From the Radio Free Michigan archives
> ftp://141.209.3.26/pub/patriot
> If you have any other files you'd like to contribute, e-mail them to
> bj496@Cleveland.Freenet.Edu.
> ------------------------------------------------
> 
>   "Every age has its own ideals of beauty, goodness and personality, but the
> practical joke is universal and timeless.  It had all started almost as a
> boyish prank one day.  Hugh de Payens and a friend decided to hide by a 
> watering place on the open road where the pilgrim transports were wont to 
> stop for refreshment and which consequently was a favorite Saracen ambush.
> Imagine - as they might have told their cronies afterwards - the 
> consternation of the Infidel marauders when they found the tables turned..."
>                         - Edith Simon
>                             "The Piebald Standard"
>   Perhaps in 1959, when this passage had been published, the romantic ideals
> of a "boyish prank" developing into the mysterious and enigmatic Knights of 
> the Temple of Solomon seemed the best explanation for the Order's founding.
> In it's day, the whole idea might have enticed more than a few other nobles 
> and knights in the East to participate in this sort of activity.
>   However, there are three important points to consider in hindsight.
>   First, the Knights Templar started off as the Poor Fellow-Soldiers of 
> Christ and the Temple of Soloman.  These Knights had a responsibility to
> defend pilgrims in the Holy Land and took vows similar to those of the 
> contemporary priesthood.  Vows that eventually included chastity and poverty, 
> which would seem to restrict some rather "boyish" activities.
>   Second, Hugues de Payen had made no secret of the fact that the life
> which the Templars were leading was wearing on himself and other members
> of the Order.  The tone of some letters indicates the Templars were on the 
> verge of disbanding the Order.
>   Third, acording to contemporary historian Guillaume de Tyre (who was
> historian to the court of Jerusalem from 1175 to 1185, and hence was 
> writing about the foundation of the Templars some seventy years later),
> the Knights originally consisted of nine brethen, the same number as in 1129.
> Actually, there were definatly 10 members in 1129, and probabaly more.
>   Given the fact that these ten members lived by a religious lifesyle with
> very few others to share their plight, it seems that dispair and discontentment
> would become a problem quickly.  If these ten men were living such "humble"
> lifestyles for so long with little or no help, what inspired them to stay
> doing it for a few weeks, let alone several years?
> THE ORIGIN OF THE ORDER OF THE TEMPLE
>   In looking for the reasons for the establishment of the Knights of the 
> Temple, one needs to determine who the founders were and what their motivations
> were.  In the case of the Templars, however, that proves to be more difficult.
> Not only did the Templar's founders live almost 900 years ago, but the first
> contemporary historian to make record of the Order wasn't writing about them 
> until neerly half a century later.
>   Information about the foundation of the Order comes from Guillaume de Tyre, 
> historian from 1167 to 1184.  Of the historians to mention the Templars before
> him, Jacques de Vitrey mentions only the Templars performance at Damascus in 
> October of 1129, and Odo de Deuil mentions the Templars only in passing in his 
> comentary on activities following Vezelay in 1146.  Fulk de Chartress,
> historian to the court in Jerusalem in the 1110s made no mention of the 
> Knights, despite Badouin II's endorsement and bestowment of the Al-Aqsa Mosque.
>   Drawing from three sources, we have the following lists;
> Les Origines...         The Knights Templar        Holy Blood, Holy Grail
>   a:Paul Naudon           a:Stephen Howarth          a:Baigent, Leigh, Lincoln
> ---------------         -------------------        ---------------------------
> Hugues de Pains         Hugh de Payens             Hugues de Payen
> Geoffroi de Saint-Omer  Geoffrey of St-Omer        Bisol de St. Omer
> Payen de Montdidier     Payen de Montdidier        Nivard de Montdidier
> Archambaud de St-Aignan Archambaud de St-Agnan     Archambaud de Saint-Aignan
> Andre de Montbard       Andre de Montbard          Andre de Montbard
> Godefroy de Bissot      Geoffrey Bisot             
> Gondemar                Gondemare                  Gondemar
> Roral/Roland            Rossal/Roland              Rossal
> Godefroy
>                                                    Hugues, Comte de Champagne
>   The above lists are justified as such;
>   Paul Naudon draws his list from the writtings of Guillaume de Tyre, historian
> to the court of Jerusalem in 1173.  It should be noted that this was more than 
> 50 years after the establishment of the Templars, and was probably drawn from
> sources supplied by the Templars.  One must make one's own judgement as to the 
> validity of any sources which the Templars may have made available to Guillaume
> de Tyre at this time.  As one of the other four authors notes, "Archbishop 
> William of Tyre...held a permanent grudge against the Templars...," and this 
> may serve to explain why Guillaume is the first Crusader historian to make any
> mention of the Templars' origins.
>   Stephen Howarth does not give a clear indication as to his source.  He also
> only lists eight founders, and says about the ninth only that "[t]radition says
> there were nine in this original brotherhood, but tradition does not give the 
> name of the ninth."  In this respect, it is perhaps Howarth's list which can be
> given the most credence, as he is willing to admit that he is unable to find
> proof to support a ninth name.
>   Michael Baigent, Richard Leigh, and Henry Lincoln give as their source a
> report known as the "Dossiers secrets."  This report is claimed to have been 
> found at the Bibliotheque Nationale in Paris.  The list is mostly accurate, 
> containing seven names which are confirmed by the other two lists.  The 
> additional name, Hugues, Comte de Champagne, is speculative, and likely false.
>   First, lets take aside the eight names which match, and produce the list of 
> eight confirmed founders, as they will be refered to from this point onward.
> Hugues de Payens        Geoffrey de St-Omer     Payen de Montdidier
> Archmabaud de St-Agnan  Andre de Montbard       Godefoy Bisol
> Gondemar                Roland
>   First, we come to the ninth name on Paul Naudon's list; Godefroy.  This is 
> probably based upon the Rule of the Temple, article 7.  The rule reads;
>         "And also present was Brother Hugues de Payens, Master of the 
>           Knighthood, with some of his brothers whom he had brought with 
>           him.  They were Brother Roland, Brother Godefroy, and Brother 
>           Geoffroi Bisot, Brother Payen de Montdidier, Brother Archambaut
>           de Saint-Amand."
> Article 7 was comprised at the Council of Troyes in 1129, along with many of 
> the earliest articles of conduct for the Order.  The list of Knights who 
> acompanied Hugues includes Godefroy de St Omer, Roland, Godefroi Bisot, Payen 
> de Montdidier, and Archambaud de St.Amand.  Apparently, Geoffrey de St Omer
> had been recorded simply as Godefroy (second on the list).
>   As for Hugues, Comte de Champagne, he is recorded historically as joining the
> Order in 1126, and is considered to be the only the second non-founding member
> (not including Count Fulk of Anjou, who had joined as an associate member in 
> 1120.  Remarkably, this is the same Fulk who married Melissande, and thereby 
> eventually became King of Jerusalem on Sept 14, 1131) along with Robert de 
> Craon, whose date of joining the Order is in question.  The reason for 
> the suggestion that Hugues de Champagne was one of the founders is that he had
> a long history of activity in the east, starting in 1104.  He returned to 
> France in 1108, then returned to the east again in 1114, intending to join 
> the "milice du Christ."  Supposedly, he changed his mind, and returned to 
> France.  Likely, he did just that, but there is still the possibility that
> the Order was esablished by 1114, or in it's early stages, and that Hugues
> did have something to do with it.  While there is little evidence to support 
> this theory, there is nothing to discount it either, as Hugues was in the 
> east at a time when the Templars would have been organizing.  For now, however,
> we will discount this, and leave the ninth founder unknown.
>   Of the other eight mentioned as founders, we know which Knights were still 
> members of the Order in 1129; Hugues de Payens and five others in Troyes with 
> Andre de Montebard and Gondemar noted in a letter from Badouin II  to St 
> Bernard before the Council of Troyes in 1129.  If there were only eight of the
> original Knights in the Order at this time, along with Robert de Craon and 
> the Comte de Champagne, who was recently admitted to the Order, this leaves us
> with the nine members stated as part of the Order.  Even if there had been a 
> ninth founder (who was not Hugues de Champagne), perhaps he had died by 1129.
>   There are two other possibilities for the unknown ninth founder, however.
>   The second Master of the Templars was Robert de Craon.  The date of his 
> joining the Order is somewhat questionable.  He is not indicated as part of 
> the Order in 1129, but there is a charter dated 1125 witnessed by "Robert the 
> Templar."  It has been suggested that Robert was the ninth founder, and that he
> is not recorded in 1129 because he is not included in Article 7 or the letter 
> Bernard.  If none of the documents availible to Guillaume had included Robert's
> name, then he would not have been included.
>   Second, if there was in fact an organization working out of the abbey on Mt 
> Sion, then perhaps someone within the abbey had helped found the order.  That 
> person may have been one Prior Arnaldus.  Several documnets of the period were 
> found bearing the seal and signature of one or another prior from the abbey on 
> Mt Sion (known as the Notre Dame de Sion).  There is one from July 19, 1116, 
> signed by Prior Arnaldus.  There is another from May 2, 1125, where Prior 
> Arnaldus' name appears with Hugues de Payens.
>   How many more connections could actually be found to link the abbey on 
> Sion III with the Templars?             
> MOUNT SION; WHY IS IT IMPOTANT?
>   Archaeologically speaking, there have been a series of constructs built
> atop Mt. Sion near Jerusalem.  However, geograpically speaking, there are 
> three rises in the area which have been called Mt. Sion over the last 3000
> years.
>   When King David captured Jerusalem in about 1000 BCE, the south-eastern
> ridge was known as Mt. Sion.  This is the site of the City of David, and is
> refered to as Sion I.  This hill has been the subject of recent excavations
> seeking more information about the City of David.
>   When King Solomon built his temple to the Lord on the ridge to the north,
> the Temple Mount was refered to as Sion.  It is refered to as Sion II or Mt.
> Moriah.
>   The Mt. Sion most commonly refered to is Sion III, which is located south-
> west of the Temple Mount.  It is on this hill that the Church of the Apostles
> sat durring the time of Jesus.  On that same site, an abbey was erected by
> order of Godfroi de Bouillon after the conquest of Jerusalem.  Today, the 
> Dormition(meaning "passing away") Abbey is located there, keeping with the 
> tradition that it marks the site of the "passing away" of Mary.
>   It is Sion III which will be focused upon here.  In addition the the 
> actual constructs found here, the history of visitors to Sion before the 
> Crusades will show that someone was interested in Mt. Sion for a very long
> time.
>   The first construction is from 73 CE.  After the destruction of the city
> of Jerusalem in 70 CE, (from Euthychius, 10th century patriarch of Alexandria,
> so, again, the information is written long after the event, and thereby 
> questionable) the Judeo-Christians who fled to Pella "returned to Jerusalem 
> in the fourth year of Vespian, and built there their church."  Their leader 
> was Simon Bar-Kleopha, second bishop of Jerualem, and a decendant of the 
> Davidic family.
>   Returning at that time, these Judeo-Christians would have at their 
> disposal the ashlars from Herod's Temple as well as ruins from other buildings
> of the old city from which to build their church.  Certainly, looking at the 
> remaining walls from the older constructions, it is obvious that blocks of 
> various sizes were used.  This church, built before the term church had come 
> into use, would have been called either a Beit or Beth Knesset, which means 
> "house of assembly."  From the Greek assembly, it became "synagogue."
>   This synagogue stood alone atop Sion III commemorating the site of the Last
> Supper and the death of Mary.  Over the next three centuries, several other 
> constructs were added.  In 333 CE, a man known as the Pilgrim of Bordeaux
> visited the site, and mentioned entering the "wall of Sion," which might have
> been a wall construced by the Judeo-Christians to fend off Pagen and Byzantine
> influence and trespass.  In about 382 CE, Theodosius I had an Octagonal church 
> constructed on Sion III next to the synagogue, a representations of which can 
> be seen in the 400 CE mosaic of the Last Supper at the Basilica of St.
> Pudentiana in Rome.(In the mosaic, the octaginal church and the synagogue 
> are just to the right of the Christ's head.)
>   This octaginal church stood next to the 1st century synagogue until about
> 415 CE, when it was replaced by the Hagia Sion Basilica, which abutted the 
> 1st century synagogue along it's north wall.  Also in 415, the bones of St.
> Stephen were found.  The then Bishop of Jerusalem, John II, had the relics of 
> St. Stephen transfered to the synagogue on Mt. Sion, where thay remanined until
> the empress Eudocia had a new church erected to honor St. Stephen, located 
> north of the Damacus Gate, in 439 CE.  The bones of St Stephen were moved to 
> the new church, however some of the bones were taken to Constantinople and 
> others went to the Mount of Olives.  The sarcophagus remained in the sanctuary
> on Mt. Sion.
>   At the time, it was believed that the "wall of Sion" was a part of the Palace
> of David, and that the City of David had stood on the same hill (the western
> hill, Sion III).  Similarly, since the kings of Judah were interred in the 
> City of David, the tombs of David and Solomon were also on the western hill.
> Two more memorial tombs were added in the 10th century to reflect this belief,
> and it was these two tombs along with St. Stephen's sarcophagus which the 
> Crusaders found upon Sion in 1099.
>   Upon thier arrival, the Crusaders found the Hagia Sion Basilica in ruins.
> On the south part of the ruins, the new abbey was built, known as Notre Dame 
> de Sion.  This Crusader church was built to include the synagogue within it,
> using the synagogue as the south-east corner.  Above the remaining walls of the
> synagogue, the Crusaders built a second floor, known as the cenacle.  This 
> cenacle commemorated the Last Supper and the Pentecost (Acts 2).
>   One unconfirmed story relating to Mt. Sion relates the account of Benjamin
> of Tudela.  While in Jerusalem, a man named Abraham told of two workers who
> had accidentally happened upon a passage and found themselves in a palace of
> marble columns, which they believed to be the Tomb of David.  They also 
> reported that a golden sceptre and a golden crown were on a table, and 
> riches were littered all around.  The pair were supposedly struck down by a 
> whirlwind and told to leave by unseen voices, and were found sick in bed, 
> claiming "We shall never again return there, for God does not want this place
> to be seen by any human being."  Most likely, the pair were lying, since the 
> City of David has been found to be on the east hill (Sion I), and the Tomb
> of David would likewise be so.
>   After the defeat at Hatin, the Crusaders entrusted the abbey to the Syrian 
> Christians, who were in turn forced to abandon the complex when it was 
> destroyed by order of one of the Ayubic sultans of Damascus in 1219 CE.
> Between 1335 and 1337 CE, a group of Franciscan fathers bought Mt. Sion from 
> the Saracens.  They repaired the roof of the cenacle and built a new monestary
> south of it.  The Franciscans were never able to occupy the ground floor of 
> the cenacle, since Moslem holy men had made their abode there.  Eventually, 
> the Moslems drove the Franscans from the site in the 16th century and had both
> the tomb and the centacle declared mosques.
> IS THERE ADDITIONAL EVIDENCE OF A LINK BETWEEN THE TEMPLARS AND THE ABBEY?
>   There was indeed an abbey constructed on the western hill(Sion III), as 
> proven by archaeological evidence.  This abbey, the Notre Dame du Sion, was
> dedicated to Mary, the mother of Jesus.  It was occupied by the Crusader 
> from 1100 until 1187, when it was turned over to the Syrian Christians.
>   The Templars, irreguardless of their founding date, were established in the 
> El Aqsa Mosque on the souternmost region of the Temple Mount Complex by order
> of Badouin II in 1118, and were using the area beneath the temple as thier
> horse stable as early as 1124.
>   (It should be noted here that the "Stable of Solomon" was not originally used
>    for livestock, but was in fact used to support the southern extension of 
>    the Temple Mount Complex, and stable is derived from the stabilizing of the 
>    Complex rather than housing livestock.  Additionally, these vaults were 
>    built by order of Herod, not Solomon.)
>   Besides the aforementioned appearance of Prior Arnaldus' signature with that
> of Hugues de Payens, there is additional connection between the Templars and
> the Notre Dame du Sion.
>   First, there is the prayer offered by the Templars upon the election of the
> Grand Master.  The prayer is recorded in Article 222 of the Templar Rule, and
> the pertinant section reads as follows;
>         "...Make safe your servant. R. My Lord, who puts his trust in you.
>          Send to him, Lord, help from the sanctuary. R. And watch over them
>             out of Zion.
>          Be to him, Lord, a tower of strength..."
> The second line in the above passage is most important.  The first part, "help
> from the sanctuary," could be a reference to either a heavenly sanctuary or an
> earthly sanctary.  Notre Dame du Sion would certanly qualify as one possible
> sanctuary.  The second part, "them out of Zion," also has two possible 
> interpretations; either watching over those who are outside of Zion (the name
> transfered upon Jerusalem from the Jesubite citadel conqured by King David),
> or being watched over from [out of] Sion.
>   Hence, the two interpretations are;
>         1. Send help to this new leader from Heaven, and watch over the 
>            others who are outside of Jerusalem.
>         2. Send help to this new leader from [pos: Notre Dame de Sion] and 
>            watch over him from Sion.
>   Under the name Zion, the city of Jerusalem had been referred to as Sion
> before; once in Psalms 136, again in Isaiah 60.  Psalms 137 recounts the loss
> of Jerusalem being mourned from exile in Babylonia durring the sixth century 
> BCE. In Isaiah, the second Isaiah calls for a return to Jerusalem/Sion. The 
> Crusaders had captured the city from the Infidels, thus symbolically answering 
> Isaiah's call, but the King of Persia had opened the city of Jerusalem to the 
> Isrealites after conquering the Babylonians in 538 BCE.  Since these two 
> Biblical references have no bearing on the Crusader situation, it seems
> unlikely that the Crusaders drew inspirations from these passages, yet the 
> Templars refer to "Sion" in their inagural prayer.
>   And the Templars definatly comitted themselves to the sanctity of the 
> mother of Jesus.  In additon to their role as peacekeepers and financers, 
> there was one other project which the Templars embarked upon on several 
> occasions.  As Edith Simon points out;
>         "They might shun the female principle, that peril to salvation,
>         incarnated in the daughters of Eve, but as the worldly knight had
>         each his lady, so, too, must they have theirs.  The churches they
>         had been empowered to build for their own use were for the most 
>         part dedicated to...Mary, the Queen of Heaven, Mercy personified."
> The Templars definatly had a very strong connection with the Notre Dame du
> Sion, else why dedicate their churches to Mary, rather then Jesus the Christ,
> of whom they were sworn knights?  
>   If the Templars were calling upon God to watch over those (either other 
> Templars or all Christians) outside of Jerusalem, then why choose Sion?  There
> were several other ways of calling for this blessing, including using the 
> name Jerusalem, or perhaps the phrase Outremer, which indicated the lands 
> "Across-the-Sea," which would have included the Kingdom of Jerusalem.
>   
>   It is almost assured that the Templars had a strong connection to the Notre
> Dame de Sion.  Also, if the 'Dossiers secrets' are reliable, Sion executed a 
> considerable influence with the Kings of Jerusalem.  Badouin II had felt
> "obliged" to Sion for his throne.  Fulk of Anjou, who was affiliated with the
> Templars, and thus with Sion, married into the throne with his marriage to
> Melissande.  Even after his departure from the Templars and until his death
> in 1143, Fulk still paid annual dues to the Templars of 30 pounds of silver,
> despite being King of the land.  The extent of the Templars influence went far
> beyond the Holy Land, and Hugues de Champagne, who was Hugues de Payens leige,
> joined the Temple, effectively pledging loyalty to his own vassal.
>   Both Fulk of Anjou and Hugues de Champagne had a long history with the Holy
> Land.  Fulk's ancestor, also named Fulk, had made the pilgrimage to the city
> of Jerusalem in 1009, at which time he supposedly bit off a chunk of rock while
> kneelin to kiss the tomb of Jesus, which he brought back to Europe and 
> enshrined within the new Church of the Holy Sepulchre.  
>   Hugues had made two journeys to the Holy Land before officially joining the 
> Templars in 1129; the first in 1104, which lasted until 1108, and the second  
> in 1114, when he set out to join the "milice du Christ."
>   Of course, "la milice du Christ" was the name by which the Templars were 
> originally known.  Saint Bernard alludes to the Templars by this name, and a 
> letter from the bishop of Chartres to Hugues contains the following;
>       "We have heard that...before leaving Jerusalem you made a vow to join
>        'la milice du Christ,' that you wish to enroll in evangelical soldiery."
> Two things can be infered from the letter;
>         1. The Templars were active by 1114, else Hugues would not have had
>             the opportunity to join the Order.
>         2. Hugues was not an original member, else he would not need to join
>             the Order, being a member already.
>   From the above, we know several things.  There was an abbey upon Sion III, 
> called the Notre Dame de Sion, inhabited by an order from 1100 to the fall of
> Jerusalem to Saladin in 1187.  The Order of the Temple existed as early as 
> 1114, perhaps even earlier.  Both the Templars and the order at Sion were 
> influential within the ruling order of Jerusalem.  Finally, both orders were 
> closely related, with Sion watching over the Templars and the Templars setting
> into motion events which were desired by both orders.
>   There arises another question, however.  How long had plans been in the works
> to establish the abbey on Sion and the Templars?  And who was responsible for 
> these actions?
> ------------------------------------------------
> (This file was found elsewhere on the Internet and uploaded to the
> Radio Free Michigan archives by the archive maintainer.
> 
> All files are ZIP archives for fast download.
>  E-mail bj496@Cleveland.Freenet.Edu)

Or see it listed here: https://cdn.preterhuman.net/texts/history/american/
Or download txt file from here: https://cdn.preterhuman.net/texts/history/american/Knights_Templar.txt


At Load flow's File, browse for the txt file:
![[Pasted image 20250211014124.png]]

Run the Load flow by pressing the play at the farthest right component:
![[Pasted image 20250211014249.png]]

See if there are errors. There is an error if the Search Results icon changed red:
![[Pasted image 20250211014751.png]]

Click Search results to see what happened. Likely it'll be OpenAI errors if anything:
- [[Langflow OpenAI Error - Exceeded your current quota]]
- [[Langflow OpenAI Error - Access to model]]

> [!note] Optional: Deep dive into AstraDB
> If you visit your collection at AstraDB, you'll see the vectors!
> ![[Pasted image 20250211015632.png]]
> 
> Zoomed in:
> ![[Pasted image 20250211015651.png]]


----

**Retrieve/query**

CHECK 1: Make sure the Prompt component is connected to OpenAI component's Input and that System Message is kept empty:
![[Pasted image 20250211020722.png]]

And make sure the prompt template is:
```
{context}

---

Given the context above, answer the question as best as possible.

Question: {question}

Answer: 
```

Rationale for check 1:
There is no need for system message because the ChatGPT will take your prompt which has the AstraDB answer and your question, then reword it into a proper answer, as if ChatGPT was the one that did the querying into your RAG content.

CHECK 2:
Make sure Chat Input outbounds to Search Query as well as Prompt's "{question}" variable:

![[Pasted image 20250211021153.png]]

Rationale for check 2:
You are querying the AstraDB vector for answers, so the AstraDB needs to receive your question. Then AstraDB's answer data is extracted into the Prompt. You also concatenate the Prompt with your original question because your Prompt is asking ChatGPT to reword the prompt into a response as if ChatGPT was the one that looked up your AstraDB. Remember the prompt has both the answer already and the original question.

After all checks passed, proceed to ask the question.

Enter either at the Chat Input or the Playground (the playground knows which flow to use BECAUSE there's only one Chat Input and it's connected to the Retrieval flow):
```
The Knights originally consisted of how many brethen?
```

So you've entered:
![[Pasted image 20250211021618.png]]

Then run the Retrieval flow (by clicking play on the farthest right component, which is the Chat Output), or wait for Playground to finish running the flow.

If in canvas, you'll get this:
![[Pasted image 20250211021717.png]]

If in Playground, you'll get this:
![[Pasted image 20250211021743.png]]

When you open the text, you'll find the Knight Templars originally had nine members and discusses who the unknown ninth member may be:

![[Pasted image 20250211021949.png]]


**Congratulations, you've successfully performed RAG!**


---

**And if you had asked an unrelated question**

If you had asked "How tall is Mt Everest" instead of asking about Knight Templars, then the AI's response would've been: "The text does not provide information on the height of Mt Everest."

This works because your prompt under the hood had instructed ChatGPT to reword the relevant answer (aka variable `{context}`) into replying to your question (variable `{question}`).

If you want to allow the user to ask about Knight Templars OR about Mt Everest, then your Prompt component (to ChatGPT model component) would have the template:
```
{context}

---

Given the context above, answer the question as best as possible.

But... the user is also allowed to ask about Mt Everest

Question: {question}

Answer: 
```