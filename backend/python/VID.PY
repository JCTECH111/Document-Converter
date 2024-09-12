import requests
from bs4 import BeautifulSoup
import os

# Function to check if the URL is a direct link
def is_direct_video_link(url):
    video_formats = ('.mp4', '.avi', '.mov', '.mkv', '.webm', '.flv')
    return url.lower().endswith(video_formats)

# Function to download the video
def download_video(video_url, output_path):
    print(f"Attempting to download video from {video_url}")
    
    # Send a GET request to the video URL
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
    }
    
    response = requests.get(video_url, stream=True, headers=headers)

    # Check if the request was successful
    if response.status_code == 200:
        with open(output_path, 'wb') as video_file:
            for chunk in response.iter_content(chunk_size=1024*1024):
                if chunk:
                    video_file.write(chunk)
        print(f"Video downloaded successfully and saved as {output_path}")
    else:
        print(f"Failed to download video. Status code: {response.status_code}")

# Function to scrape the page for video links
def scrape_for_video(url):
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
    }
    
    response = requests.get(url, headers=headers)
    
    if response.status_code == 200:
        soup = BeautifulSoup(response.content, 'html.parser')
        # Look for video tags or video-like content
        video_tag = soup.find('video')
        
        # If a video tag is found, try to extract the source
        if video_tag:
            video_source = video_tag.find('source')
            if video_source and 'src' in video_source.attrs:
                return video_source['src']
            # If no source tag, the video tag itself might have the src
            elif 'src' in video_tag.attrs:
                return video_tag['src']
        
        # Otherwise, search for links to common video formats
        for link in soup.find_all('a', href=True):
            if is_direct_video_link(link['href']):
                return link['href']
    
    return None

# Main function to process the video download or scrape
def process_video_download(url, output_path):
    if is_direct_video_link(url):
        # If it's a direct video link, download directly
        download_video(url, output_path)
    else:
        print(f"{url} is not a direct video link. Scraping the page for video...")
        video_url = scrape_for_video(url)
        
        if video_url:
            # Some URLs might be relative, so make sure they are absolute
            if not video_url.startswith('http'):
                video_url = os.path.join(url, video_url)
                
            print(f"Found video URL: {video_url}")
            download_video(video_url, output_path)
        else:
            print("No video link found on the page.")

# Example usage
video_url = 'https://www.facebook.com/share/r/PhjQZtmsbtM9ufCU/?mibextid=oFDknk'
output_path = 'output_video.mp4'
process_video_download(video_url, output_path)