![](lRid9Ju.png)

![](PWVTIvs.png)

Note we are using expo. Here's the code:
```
import React, { useState, useEffect } from 'react';  
import Ionicons from '@expo/vector-icons/Ionicons';  
import { StyleSheet, Modal, Pressable, View, Text, TextInput, Button, Alert, Image, ScrollView } from 'react-native';  
  
import * as Sharing from 'expo-sharing';  
import * as Clipboard from 'expo-clipboard';  
  
const ShareUI = ({ url }) => {  
  const [message, setMessage] = useState("");  
  const [isMessageError, setIsMessageError] = useState(false);  
  
  useEffect(() => {  
    setTimeout(()=>{  
      setMessage("");  
    }, 5000)  
  }, [message]);  
  
  const handleShare = async () => {  
    if (await Sharing.isAvailableAsync()) {  
      try {  
        await Sharing.shareAsync(url, {  
          mimeType: 'text/plain',  
          dialogTitle: 'Share this link',  
        });  
      } catch (error) {  
        setIsMessageError(true);  
        setMessage("ERROR: Could not share the link.");  
      }  
    } else {  
      setIsMessageError(false);  
      setMessage("Sharing not available', 'Sharing is not available on this device.");  
    }  
  };  
  
  const handleCopyLink = () => {  
    Clipboard.setStringAsync(url);  
    setIsMessageError(false);  
    setMessage("Link copied to clipboard! Share with friends!");  
  };  
  
  return (  
    <View className="flex flex-col items-center align-center">  
      <View className="flex flex-row justify-end mt-8 w-full">  
        <Pressable  
          onPress={handleShare}  
          className="flex-row align-center items-center bg-blue-400 border-2 border-blue-200 py-1 mt-4 px-6 mx-auto rounded"  
        >  
          <Ionicons name="share-outline" size={14} color={"white"}/>  
          <Text className="text-white"> Share Link</Text>  
        </Pressable>  
        <View><Text>&nbsp;&nbsp;</Text></View>  
        <Pressable  
          onPress={handleCopyLink}  
          className="flex-row align-center items-center bg-blue-400 border-2 border-blue-200 py-1 mt-4 px-6 mx-auto rounded"  
        >  
          <Ionicons name="copy-outline" size={14} color={"white"}/>  
          <Text className="text-white"> Copy Link</Text>  
        </Pressable>  
      </View>  
      <View className="mt-8">  
        <Text className={(isMessageError?"text-red-400":"text-green-600")+" text-center text-sm"}>&nbsp;{message.length > 0 && message}</Text>  
      </View>  
    </View>  
  );  
};
```


  
  
Use `<ShareUI url={url}/>`  in your component. The url is what copies and shares