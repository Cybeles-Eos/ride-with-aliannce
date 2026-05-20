# Debugging Guide - Image Attachment ID Storage Issue

## Issue Description

AJAX image upload works correctly (you see "Image uploaded successfully!" message), but the attachment ID is not being saved to the `sections` table `value` field when the form is submitted.

## Debugging Tools Implemented

### 1. Backend Logging (Laravel)

**File Modified:** `app/Http/Controllers/PageController.php`

**Location:** `processSectionTemplateFields()` method (lines 452-571)

**Logs Added:**
- START: Shows all incoming request data with `section_` prefix
- Section Templates: Shows which sections have templates and fields
- Extracted Data: Shows what data was extracted from inputs
- Processing: Shows each section being processed
- Save Status: Shows data before/after merge and final saved value
- END: Summary of processing

**Log Location:** `storage/logs/laravel.log`

### 2. Frontend Logging (JavaScript)

**File Modified:** `resources/views/admin/pages/page/edit.blade.php`

**Location:** Form submit handler (lines 110-154)

**Logs Added:**
- Shows all section template inputs before submission
- Lists each input with name, value, and type
- Counts total section inputs found

**Log Location:** Browser Console (F12 → Console tab)

## How to Debug

### Step 1: Clear Logs

```bash
# Clear Laravel log
echo "" > storage/logs/laravel.log

# Or delete the file
rm storage/logs/laravel.log
```

### Step 2: Open Browser Console

1. Press F12 to open Developer Tools
2. Go to "Console" tab
3. Clear any existing logs (trash icon or Ctrl+L)

### Step 3: Test the Upload Flow

1. Navigate to Pages → Edit Page
2. Find a section with template fields (or add one)
3. Click "Choose File" for an image field
4. Select an image file
5. Wait for "Image uploaded successfully!" notification
6. **BEFORE SUBMITTING:** Right-click on the page → Inspect
7. Find the hidden input field (should look like `<input type="hidden" name="section_2_image" value="456">`)
8. Verify the value is NOT "0" but an actual attachment ID
9. Click "Save" button
10. Check the console output

### Step 4: Review Browser Console Logs

You should see output like this:

```javascript
=== FORM SUBMISSION STARTED ===
Section input: section_2_title = Test
Section input: section_2_image = 456  // ← This should be a number, not "0"
All section template inputs: {
  section_2_title: "Test",
  section_2_image: "456"
}
Total section inputs found: 2
=== SUBMITTING FORM NOW ===
```

**Key Questions:**
- Is `section_X_image` present in the logs?
- Does it have the attachment ID or "0"?
- Is the input name correct (format: `section_{id}_{alias}`)?

### Step 5: Review Laravel Logs

Open `storage/logs/laravel.log` and search for "Processing Section Template Fields".

You should see entries like:

```
[2025-11-24 12:34:56] local.INFO: === Processing Section Template Fields START === 
{
  "page_id": 1,
  "page_name": "Home",
  "user_id": 1,
  "section_inputs": {
    "section_2_title": "Test",
    "section_2_image": "456"  ← Should be attachment ID
  }
}

[2025-11-24 12:34:56] local.INFO: Sections with Templates 
{
  "sections": [
    {
      "id": 2,
      "name": "Test Section",
      "section_template_id": 1,
      "has_template": true,
      "field_count": 2,
      "fields": {
        "5": "title",
        "6": "image"
      }
    }
  ]
}

[2025-11-24 12:34:56] local.INFO: Extracted Section Data from Inputs 
{
  "section_data": {
    "2": {
      "title": "Test",
      "image": "456"  ← Should be here
    }
  }
}

[2025-11-24 12:34:56] local.INFO: Section Data Saved Successfully 
{
  "section_id": 2,
  "merged_data": {
    "title": "Test",
    "image": "456"  ← Should be here
  },
  "final_value": "{\"title\":\"Test\",\"image\":\"456\"}"  ← Final JSON
}
```

## Common Issues & Solutions

### Issue 1: Hidden Input Shows "0" Instead of Attachment ID

**Symptom:** Browser console shows `section_2_image = 0`

**Cause:** AJAX handler didn't update the hidden input

**Solution:**
1. Check if AJAX upload succeeded (check network tab)
2. Verify the AJAX handler in `page_sections.blade.php` is finding the hidden input
3. Look for the code around line 293-312 in `page_sections.blade.php`

**Debug:** Add this to AJAX success handler:
```javascript
console.log('Hidden input found:', $hiddenInput.length);
console.log('Hidden input selector:', $hiddenInput.attr('name'));
console.log('Value set to:', response.data.id);
```

### Issue 2: Section Input Not in Form Submission

**Symptom:** `section_X_image` not in console logs during form submit

**Cause:** Hidden input is outside the form or has wrong name

**Solution:**
1. Inspect the DOM to find the hidden input
2. Verify it's inside `<form id="edit-page">`
3. Check the `name` attribute matches pattern: `section_{id}_{alias}`

### Issue 3: Value "0" Converted to null

**Symptom:** Laravel logs show `"image": null` instead of the ID

**Cause:** Code on line 488 in PageController converts "0" to null

**Current Code:**
```php
$sectionData[$sectionId][$fieldAlias] = $inputValue == '0' ? null : $inputValue;
```

**Why:** This is intentional - "0" means "no image selected"

**Solution:** Ensure AJAX updates hidden input to actual ID, not "0"

### Issue 4: Section Not Found or No Template

**Symptom:** Laravel log shows "Section Not Found or No Template"

**Cause:** Section doesn't have a section_template_id

**Solution:**
1. Check the `sections` table in database
2. Ensure the section has `section_template_id` set
3. Run: `SELECT id, name, section_template_id FROM sections WHERE id = X;`

### Issue 5: Data Not Persisting After Save

**Symptom:** Logs show data saved, but reloading page shows no image

**Cause:** JSON encoding issue or value field not being saved

**Solution:**
1. Check database directly: `SELECT id, name, value FROM sections WHERE id = X;`
2. Verify the `value` field contains JSON with the image ID
3. Expected format: `{"title":"Test","image":"456"}`

## Testing Checklist

Use this checklist to debug the issue:

- [ ] Clear Laravel log file
- [ ] Clear browser console
- [ ] Navigate to Edit Page
- [ ] Open browser console (F12)
- [ ] Select an image file
- [ ] Verify "Image uploaded successfully!" appears
- [ ] Inspect hidden input - verify value is attachment ID
- [ ] Click Save button
- [ ] Check browser console for section inputs
- [ ] Verify `section_X_image` has attachment ID (not "0")
- [ ] Check Laravel log for processing logs
- [ ] Verify "section_inputs" contains the image field
- [ ] Verify "Extracted Section Data" includes image ID
- [ ] Verify "Section Data Saved Successfully" shows correct value
- [ ] Check database: `SELECT value FROM sections WHERE id = X;`
- [ ] Reload edit page and verify image displays

## Database Query to Check

```sql
-- Check section data
SELECT 
    id,
    name,
    section_template_id,
    type,
    value,
    is_active
FROM sections
WHERE id = YOUR_SECTION_ID;

-- Check attachments table
SELECT id, name, alias, folder, mime, extension, created_at
FROM attachments
ORDER BY created_at DESC
LIMIT 10;

-- Check if attachment ID matches
-- The value field should contain JSON like: {"title":"Test","image":"456"}
-- Where 456 matches an ID in the attachments table
```

## Expected Flow

### 1. AJAX Upload Phase

```
User selects file
  ↓
JavaScript captures file
  ↓
AJAX POST to /admin/upload
  ↓
Server creates Attachment record (id: 456)
  ↓
Returns JSON: {status: true, data: {id: 456, name: "file.jpg"}}
  ↓
JavaScript updates hidden input: value="456"
  ↓
User sees "Image uploaded successfully!"
```

### 2. Form Submission Phase

```
User clicks Save
  ↓
JavaScript logs all section inputs
  ↓
Form submits to /admin/pages/update/{id}
  ↓
Controller: PageController@update()
  ↓
Calls: processSectionTemplateFields($request, $page)
  ↓
Extracts: section_2_image = "456"
  ↓
Saves to Section: value = {"title":"Test","image":"456"}
  ↓
Redirects to pages index
```

### 3. Display Phase

```
User edits page again
  ↓
Controller loads section data
  ↓
Decodes JSON: {"title":"Test","image":"456"}
  ↓
Finds attachment: Attachment::find(456)
  ↓
Renders image in form
```

## Next Steps

After reviewing the logs, you should be able to identify which phase is failing:

1. **AJAX Phase Fail:** Hidden input still has "0" → Fix AJAX handler
2. **Form Submit Fail:** Input not in form → Fix HTML structure
3. **Backend Fail:** Data not extracted → Fix backend logic
4. **Save Fail:** Data not persisting → Check database/model

## Support

If you still have issues after debugging:

1. Share the browser console output (screenshot or copy/paste)
2. Share the Laravel log entries for the request
3. Share the database query results for the section
4. Note which phase is failing based on the logs

## Files to Check

- Backend: `app/Http/Controllers/PageController.php`
- AJAX Handler: `resources/views/admin/pages/page/page_sections.blade.php` (lines 243-346)
- Form Submit: `resources/views/admin/pages/page/edit.blade.php` (lines 110-154)
- Attachment Component: `resources/views/admin/components/attachment.blade.php`
- Routes: `routes/admin.php` (line 108)
- Database: `sections` table, `attachments` table

## Log Cleanup

After debugging, you may want to remove the verbose logging:

```bash
# To reduce log noise, you can comment out or remove the \Log::info() calls
# from PageController.php and the console.log() calls from edit.blade.php
```

## Status

✅ Debugging tools installed and ready
📝 Follow the steps above to identify the issue
💡 Logs will show exactly where the data is being lost

