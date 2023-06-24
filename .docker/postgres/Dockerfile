FROM postgres:15.2

ARG user
ARG uid

ENV HOME_USER=$user

RUN useradd -G www-data,root,sudo,postgres -u $uid -d /home/$user $user

RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

RUN ln -sf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime

COPY backup.sh /backup
RUN chmod +x /backup

COPY restore.sh /restore
RUN chmod +x /restore

# USER $user