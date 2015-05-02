setwd("/Users/willy/code/sandbox/assdata")

library(chron)

# Raw Processing
stories = read.csv("killstory.csv", sep=",", quote="\"", header=F, col.names=c("killer", "dead", "is_kill", "story_len", "time"))
users = read.csv("users.csv", col.names=c("userid", "uname", "name", "codename", "pass", "dead", "to_kill", "killed", "time"))

kills = stories[stories$is_kill == 1,]
deaths = stories[stories$is_kill != 1,]

tz.diff = as.difftime("3", format="%H")
deaths$time = as.POSIXlt(deaths$time, tz="UCT") + tz.diff
kills$time = as.POSIXlt(kills$time, tz="UCT") + tz.diff

# EXPLORE
hist(hours(kills$time), breaks=seq(0,24) - .5, xlab="Hour of Day", ylab="Number of Kills", main="Kills by Hour")


start.time = as.POSIXlt("2014-04-29 00:00:00", tz="UCT")

min_diff = function(earlier.time, later.time){
  as.numeric(later.time - earlier.time, units = "mins")
}

mins_from_start = function(time.vec, start.time){
  vapply((time.vec - start.time), function(x){as.numeric(x, units="mins")}, 1)
}

wait.times = function(times){
  c(times[1], diff(times))
}

kills$mins.after.start = mins_from_start(kills$time, start.time)
kills$wait.times = wait.times(kills$mins.after.start)
deaths$mins.after.start = mins_from_start(deaths$time, start.time)

# Time-adjust
# Remove the 1 Sunday in the middle (May 5th)
kills$mins.after.start = kills$mins.after.start - (kills$mins.after.start > 6500)*(24*60)

# We will adjust time between [1am, 10am) to be facto of their original length
time.contraction = 9
start.contraction = 60
end.contraction = 60*10
contraction.in.day = (end.contraction - start.contraction)*(1 - 1/time.contraction)

adjust.time = function(minutes.after.start){
  mins.in.day = 24*60
  mins.to.subtract = 0
  days = floor(minutes.after.start / mins.in.day)
  mins.to.subtract = mins.to.subtract + contraction.in.day*days
  last.days.mins = minutes.after.start %% (mins.in.day)

  if(last.days.mins > end.contraction){
    mins.to.subtract = mins.to.subtract + contraction.in.day
  } else if (last.days.mins > start.contraction){
    mins.to.subtract = mins.to.subtract + (last.days.mins - start.contraction)*(1 - 1/time.contraction)
  }

  minutes.after.start - mins.to.subtract
}

stopifnot(adjust.time(10) == 10)
stopifnot(adjust.time(100) == 100 - 40*(1 - 1/time.contraction))
stopifnot(adjust.time(24*60) == (24*60) - contraction.in.day)
stopifnot(adjust.time(24*60+100) == (24*60+100) - 40*(1- 1/time.contraction) - contraction.in.day)

kills$adj.mins.after.start = vapply(kills$mins.after.start, adjust.time, 1.1)
kills$adj.wait.times = wait.times(kills$adj.mins.after.start)

fit.expo = function(wait.times, main=NULL, xlab=NULL, ylab=NULL){
  if(!is.null(main)){
    hist(wait.times, freq=F, main=main, xlab=xlab, ylab=ylab)    
  } else {
    hist(wait.times, freq=F)
  }
  lines(seq(0,floor(max(wait.times) + 10)), dexp(seq(0, floor(max(wait.times) + 10)), 1/mean(wait.times)))
  mean(wait.times)
}

kills$adj.wait.times.lambda = kills$adj.wait.times*seq(62, 62-length(kills$adj.wait.times) + 1)
fit.expo(kills$adj.wait.times.lambda, 
         main="Adjusted Wait Times", 
         xlab="Wait Times (Minutes After Start)",
         ylab="Density")

alpha=.001+length(kills$adj.wait.times.lambda)
beta=.001 + sum(kills$adj.wait.times.lambda/(60))
post.dist = list(d=function(x){dgamma(x,alpha,beta)},
                 q=function(x){qgamma(x,alpha,beta)},
                 p=function(x){pgamma(x,alpha,beta)})
x = seq(45,130,1)
post.mean = 1/(50/sum(kills$adj.wait.times.lambda/(60)))
lower.95 = 1/post.dist$q(.975)
upper.95 = 1/post.dist$q(.025)

plot(x,post.dist$d(1/x), 
      type="l", main="Lambda Posterior", xlab="1/Lambda (Hours)", ylab="Density")

text(post.mean, post.dist$d(1/post.mean), labels="mean = 77.94", adj=1.1, cex=.8)
abline(v=lower.95, lty=c(2))
abline(v=upper.95, lty=c(2))
x = seq(lower.95, upper.95)
lines(x, rep(75, length(x)), lty=2, lwd=2)
text(80, 90, labels="95% Interval [60.15,105.00]", cex=.8)

post.predict = function(n.alive) {
  list(f=function(x){(alpha*beta^alpha)/(beta+x)^(alpha+1)},
       F=function(x){-(beta^alpha)*(beta+x*(n.alive))^-alpha} + 1,
       mean=(beta)/(n.alive*(alpha-1)),
       var.mle=((beta)/(n.alive*(alpha-1)))^-2)
}

plot(cumsum((post.mean/(66:1))[1:55])/16, 65:(65-54), 
     type="s", 
     main="Expected v. Actual Players Left 2015", 
     xlim=c(0,8),
     xlab="Days", 
     ylab="Players Left",
     col=4,
     lwd=2)
lines(kills.2015$mins.after.start/(60*24), 66 - 1:55, type="s")
legend(5.5,65, legend=c("Expected", "Actual"), col=c(4,1), lwd=c(2,1))
