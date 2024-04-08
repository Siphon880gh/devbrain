We will use a financial services booking system as an example for date and time selection.

## Building a Financial Services Booking System with React

Clients can select a consultation type, choose a date and time, and schedule their appointment, using React's state and effect hooks for dynamic user interactions.

## Prerequisites
- Basic understanding of React
- Node.js and npm installed
- `react-calendar` package installed for date selection

## Component Setup

Begin by importing the necessary React hooks and the `react-calendar` package for the date selection feature:

```jsx
import { useState, useEffect } from "react";
import Calendar from "react-calendar";
```

### Calendar and Time Selection

For the date selection, we use `react-calendar`, a handy library that provides a customizable calendar component. However, for the time selection, there's no need for an additional library. The HTML `<input type="time">` element serves our purpose well, offering a user-friendly interface to pick a time without any extra dependencies.

```jsx
<Calendar onChange={setDate} value={dateSelected} />
<input
  type="time"
  value={timeSelected}
  onChange={(event) => setTime(event.target.value)}
  min="08:00"
  max="17:00"
  step="1800" // 1800 seconds = 30 minutes
/>

```

## Initializing State

In the `FinancialServices` component, initialize state variables to manage the selected service, date, time, and UI elements:

```jsx
function FinancialServices() {
  const [serviceSelected, setService] = useState("");
  const [dateSelected, setDate] = useState(new Date());
  const [timeSelected, setTime] = useState("09:00");
  const [dateModalOpened, setModalOpened] = useState(false);
  const [dateTimePanel, switchDateTimePanel] = useState("DATE");
}
```

## Handling Appointment Submission

Create a function to process appointment submissions, which can be linked to a backend service for persistence:

```jsx
function submitAppointment() {
  const formattedDate = dateSelected.toLocaleDateString();
  const formattedTime = timeSelected;
  alert(`Appointment scheduled for ${formattedDate} at ${formattedTime} for ${serviceSelected}.`);
  setModalOpened(false);
}
```

## User Interface

Construct modals for date and time selection and interface elements for picking financial services.

```jsx
<div className={"modal" + (dateModalOpened ? "" : " hidden")}>
  {/* Date or Time Selection Panel */}
</div>
<main>
  {/* Financial Service Selection Cards */}
</main>
```

## Effect Hooks

Effect hooks (`useEffect`) are used here to monitor state changes. They're invaluable for debugging, letting you verify that the component's state updates as expected when users interact with the UI.

```jsx
useEffect(() => {
  console.log("CHANGED DATE: " + dateSelected);
}, [dateSelected]);

useEffect(() => {
  console.log("CHANGED SERVICE: " + serviceSelected);
}, [serviceSelected]);
```

## Conclusion

This tutorial outlines the creation of a basic financial services booking system. Clients can select a service, pick a date and time, and book their appointment. Enhancements can include database integration, user authentication, and checking the availability of financial advisors in real-time.