FROM node:current

WORKDIR "/var/www/html"

COPY ./src .

# Expose the port Vite runs on
EXPOSE 3000

# # Start the Vite server
CMD ["npm", "run", "dev"]