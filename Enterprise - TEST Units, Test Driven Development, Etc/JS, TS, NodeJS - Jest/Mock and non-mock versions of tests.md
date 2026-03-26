# Mock and non-mock versions of tests

Can't unmock once it's been mocked in the same test file.
jest.unmock("../lib/db") and various not working.

So just do:
Class.mock.test.js
Class.test.js

That Class.mock.test.js calls jest.mock(...)

Refer to lesson on mocking classes