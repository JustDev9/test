import { createClient } from '@supabase/supabase-js'

const supabaseUrl = 'https://jsyjrlhilcdgtmavjnvz.supabase.co'
const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImpzeWpybGhpbGNkZ3RtYXZqbnZ6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mzk5MjQ5NzAsImV4cCI6MjA1NTUwMDk3MH0.8XgXgXgXgXgXgXgXgXgXgXgXgXgXgXgXgXgXgXgXg'

export const supabase = createClient(supabaseUrl, supabaseKey)