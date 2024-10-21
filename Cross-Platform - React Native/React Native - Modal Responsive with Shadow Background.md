

```
import { Dimensions } from 'react-native';
import { useEffect, useState } from 'react';
import { StyleSheet, Modal, View, ScrollView, Text, Button, TouchableOpacity } from 'react-native'

export function Module() {
  const [windowWidth, setWindowWidth] = useState(0);
  const [windowHeight, setWindowHeight] = useState(0);
  const [widthContainerRatio, setWidthContainerRatio] = useState(0.9);
  const [modalNeeded, setModalNeeded] = useState(true);
	
	useEffect(() => {
		const { width, height } = Dimensions.get("window");
		setWindowWidth(width);
		setWindowHeight(height);
	}, []);

	useEffect(() => {
		if (windowWidth < 576) {
		  setWidthContainerRatio(1); // 100% width for small screens
		} else if (windowWidth >= 576 && windowWidth < 768) {
		  setWidthContainerRatio(0.9); // 90% width for small breakpoints
		} else if (windowWidth >= 768 && windowWidth < 992) {
		  setWidthContainerRatio(0.85); // 85% width for medium screens
		} else if (windowWidth >= 992 && windowWidth < 1200) {
		  setWidthContainerRatio(0.8); // 80% width for large screens
		} else if (windowWidth >= 1200) {
		  setWidthContainerRatio(0.75); // 75% width for extra-large screens
		}
	}, [windowWidth]);

	function seenModal() { 
		setModalNeeded(false); 
	}

  return (
    <>
	  <Modal
		animationType="slide"
		transparent={true}
		visible={modalNeeded}>
		<TouchableOpacity style={styles.modalOverlay} onPress={seenModal}>
			<ScrollView className={{flex:1, display:"flex", justifyContent:"center", alignItems:"center", zIndex:10, marginTop:24}}>
			<View className="flex flex-col justify-between m-5 bg-white rounded-xl p-9 items-center shadow-lg" style={[styles.modalView, {width:windowWidth*widthContainerRatio, height:windowHeight*.8}]}>
			  {/* <Text role="debug" className="mb-4 text-center">{inquiryIndex}</Text> */}
			  
			  <View id="info-main">
				<View className="mt-8"><Text></Text></View>
				{/* <Text className="mb-4 text-center">{gridData[inquiryIndex - 1].description}</Text> */}
				<Text className="mb-4 text-center">Testing</Text>
				<View className="mt-8"><Text></Text></View>
			  </View>
			  <View id="info-btn-group" className="flex flex-col justify-center" style={{height:100}}>
				<Button
				  title="Dismissed"
				  style={[styles.button, styles.buttonClose]}
				  onPress={seenModal}>
				</Button>
			  </View>
			</View>
		  </ScrollView>
		</TouchableOpacity>
	  </Modal>
	  {/* The rest... */}
    </>
  );
} // Module


const styles = StyleSheet.create({  
  modalView: {
    elevation: 5,
  },
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0, 0, 0, 0.7)', // Dark shadow background
    justifyContent: 'center',
    alignItems: 'center',
  },
  button: {
    borderRadius: 20,
    padding: 10,
    elevation: 2,
  },
  buttonOpen: {
    backgroundColor: '#F194FF',
  },
  buttonClose: {
    backgroundColor: '#2196F3',
  }
});

```

**You can enhance:**

- If you're using global useState to track if the model was seen, you can add a:
  ```
    useEffect(()=>{
    if(keyValueStore?.seenOnBoarding) {
      setModalOnboardNeeded(false)
    }
	```


**Explanation:**
- Window width and height of your screen is gotten from react-native's `Dimensions.get("window");`
- Then based on the window width and height, we responsively set the container so it contracts and expands reasonably based on the device screen's width (on mobile, content should be 100% screen width; on desktop, there should be some space left and right, so the content should be some percent of the screen width). That sets widthContainerRatio where 1 means take up 100% of the screen width and 50% means take up only 50% of the screen, then in the jsx we have the modal content centered and the width be widthContainerRatio percent of the screen width: `style={[styles.modalView, {width:windowWidth*widthContainerRatio, height:windowHeight*.8}]}>`
- Modal (from react-native) allows an overlay content window on top of the current window. Its visibility can be set based on another variable like in the inline attribute `visible={modalNeeded}`
- Directly nested in Modal is the TouchableOpacity that is the black shadow background that's behind the modal foreground, that when touched, will turn modalNeeded to false, so that the modal's visibility is none. Similarly the button titled "Dismiss" also does the same.
- Content is in a ScrollView so that the content can be scrolled rather than be clipped off. The ScrollView's direct children are a content View and a buttons View, so we can justify so that the button's aligned to the bottom of the modal and so that the main content's aligned to the top of the modal.