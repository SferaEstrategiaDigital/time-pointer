FROM node:14

# Arguments defined in docker-compose.yml
ARG user
ARG uid

RUN groupmod -g 1001 node && usermod -u 1001 -g 1001 node

RUN useradd -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.npm && chown -R $user:$user /home/$user

RUN ln -sf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime

USER $user